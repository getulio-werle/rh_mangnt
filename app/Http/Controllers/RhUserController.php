<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RhUserController extends Controller
{
    public function rhColaborators(): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $colaborators = User::with('details')->where('role', 'rh')->get();  

        return view('colaborators.colaborators', compact('colaborators'));
    }

    public function addRhColaborator(): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $departments = Department::all();
        
        return view('colaborators.add-rh-colaborator', compact('departments'));
    }

    public function createRhColaborator(Request $request)// : View | RedirectResponse 
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

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-rh-colaborator', compact('colaborator'));
    }

    public function deleteRhColaboratorConfirm($id) : RedirectResponse 
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        $colaborator = User::findOrFail($id);
        $colaborator_details = UserDetail::where('user_id', $id);
        $colaborator_details->delete();
        $colaborator->delete();

        return redirect()->route('colaborators.rh');
    }

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
