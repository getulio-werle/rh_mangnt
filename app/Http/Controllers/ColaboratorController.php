<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ColaboratorController extends Controller
{
    // --------------------------------------------------------------
    // General colaborators
    // --------------------------------------------------------------

    public function getAllColaborators() : View | RedirectResponse // get all colaborators, except admin user
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $colaborators = User::withTrashed()
                        ->with(['details' => function (Builder $query) {
                            $query->withTrashed();
                        }])
                        ->where('id', '!=', Auth::user()->id)
                        ->get();

        return view('colaborators.general-colaborators')->with('colaborators', $colaborators);
    }

    public function getColaborators() : View | RedirectResponse // get colaborators, except admin and rh users
    {
        if (!Gate::allows('rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $colaborators = User::withTrashed()
                        ->with(['details' => function (Builder $query) {
                            $query->withTrashed();
                        }])
                        ->where('role', '!=', 'admin')
                        ->where('role', '!=', 'rh')
                        ->get();

        return view('colaborators.general-colaborators')->with('colaborators', $colaborators);
    }

    public function colaboratorDetails($id) : View | RedirectResponse
    {
        if (!Gate::any(['admin', 'rh'])) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }

        $colaborator = User::where('role', '!=', 'admin')
                            ->findOrFail($id);

        if (Auth::user()->role == 'rh' && $colaborator->role == 'rh') {
            return abort(403, 'You are not authorized to access this page');
        }

        return view('colaborators.colaborator-details')->with('colaborator', $colaborator);
    }

    public function addColaborator(): View | RedirectResponse
    {
        if (!Gate::allows('rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $departments = Department::where('id', '>', '2')->get();
        
        return view('colaborators.add-colaborator', compact('departments'));
    }

    public function createColaborator(Request $request) : View | RedirectResponse 
    {
        if (!Gate::allows('rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $department = $this->decrypt($request->department);

        if ($department <= 2) {
            return redirect()->back();
        }

        $request->merge([
            'department' => $department,
        ]);

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'department' => 'required|exists:departments,id',
                'address' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'city' => 'required|string|max:50',
                'phone' => 'required|string|max:50',
                'salary' => 'required|decimal:2',
                'admission_date' => 'required|date_format:Y-m-d',
            ]
        );

        $token = Str::random(60);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->department_id = $request->department;
        $user->role = 'colaborator';
        $user->permissions = '["colaborator"]';
        $user->save();

        $user->details()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'admission_date' => $request->admission_date
        ]);

        // send email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('colaborators');
    }

    public function editColaborator($id) : View | RedirectResponse 
    {
        if (!Gate::allows('rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        $colaborator = User::with('details')
                        ->where('role', '!=', 'admin')
                        ->where('role', '!=', 'rh')
                        ->findOrFail($id);

        return view('colaborators.edit-colaborator', compact('colaborator'));
    }

    public function alterColaborator(Request $request) : View | RedirectResponse
    {
        if (!Gate::allows('rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $request->validate([
            'id' => 'required',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ]);

        $id = $this->decrypt($request->id);

        $user = User::where('role', '!=', 'admin')
                    ->where('role', '!=', 'rh')
                    ->findOrFail($id);

        $user->details->update([
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        return redirect()->route('colaborators');
    }

    public function deleteColaborator($id) : View | RedirectResponse
    {
        if (!Gate::any(['admin', 'rh'])) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }
        
        $colaborator = User::where('id', '>', 1)
                            ->findOrFail($id);
        
        if (Auth::user()->role == 'rh' && $colaborator->role == 'rh') {
            return redirect()->back();
        }

        return view('colaborators.delete-colaborator-confirm')->with('colaborator', $colaborator);
    }

    public function deleteColaboratorConfirm($id) : RedirectResponse
    {
        if (!Gate::any(['admin', 'rh'])) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }
        
        $colaborator = User::where('id', '>', 1)
                            ->findOrFail($id);
        $colaborator_details = UserDetail::where('user_id', $id)->first();
        
        if (Auth::user()->role == 'rh' && $colaborator->role == 'rh') {
            return redirect()->back();
        }

        $colaborator_details->delete();
        $colaborator->delete();

        return redirect()->route('colaborators');
    }

    public function restoreColaborator($id) : RedirectResponse
    {
        if (!Gate::any(['admin', 'rh'])) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }
        
        $colaborator = User::withTrashed()->findOrFail($id);
        $colaborator_details = UserDetail::withTrashed()->where('user_id', $id);

        $colaborator->restore();
        $colaborator_details->restore();
        
        return redirect()->route('colaborators');
    }

    // --------------------------------------------------------------
    // RH Colaborators
    // --------------------------------------------------------------

    public function getRhColaborators(): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $colaborators = User::withTrashed()
                        ->with(['details' => function (Builder $query) {
                            $query->withTrashed();
                        }])
                        ->where('role', 'rh')
                        ->get();

        return view('colaborators.rh-colaborators', compact('colaborators'));
    }

    public function addRhColaborator(): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $departments = Department::all();
        
        return view('colaborators.add-rh-colaborator', compact('departments'));
    }

    public function createRhColaborator(Request $request) : View | RedirectResponse 
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $department = $this->decrypt($request->department);

        if ($department != 2) {
            return redirect()->back();
        }

        $request->merge([
            'department' => $department,
        ]);

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'department' => 'required|exists:departments,id',
                'address' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'city' => 'required|string|max:50',
                'phone' => 'required|string|max:50',
                'salary' => 'required|decimal:2',
                'admission_date' => 'required|date_format:Y-m-d',
            ]
        );

        $token = Str::random(60);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->department_id = $request->department;
        $user->role = 'rh';
        $user->permissions = '["rh"]';
        $user->save();

        $user->details()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'admission_date' => $request->admission_date
        ]);

        // send email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('colaborators.rh');
    }

    public function editRhColaborator($id) : View | RedirectResponse 
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }

        $colaborator = User::with('details')->findOrFail($id);

        return view('colaborators.edit-rh-colaborator', compact('colaborator'));
    }

    public function alterRhColaborator(Request $request) : View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $request->validate([
            'id' => 'required',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ]);

        $id = $this->decrypt($request->id);

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }

        $user = User::findOrFail($id);

        $user->details->update([
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        return redirect()->route('colaborators.rh');
    }

    public function deleteRhColaborator($id) : View | RedirectResponse 
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-colaborator-confirm', compact('colaborator'));
    }

    public function deleteRhColaboratorConfirm($id) : RedirectResponse 
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (Auth::user()->id == $id) {
            return redirect()->back();
        }

        $colaborator = User::findOrFail($id);
        $colaborator_details = UserDetail::where('user_id', $id);
        $colaborator_details->delete();
        $colaborator->delete();

        return redirect()->route('colaborators.rh');
    }

    public function restoreRhColaborator($id) : RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        $colaborator = User::withTrashed()->findOrFail($id);
        $colaborator_details = UserDetail::withTrashed()->where('user_id', $id);

        $colaborator->restore();
        $colaborator_details->restore();

        return redirect()->route('colaborators.rh');
    }

    // --------------------------------------------------------------
    // Helper Functions
    // --------------------------------------------------------------

    private function decrypt($value) : string | bool
    {
        try {
            $value = Crypt::decrypt($value);
            return $value;
        } catch (\Exception $e) {
            return false;
        }
    }
}
