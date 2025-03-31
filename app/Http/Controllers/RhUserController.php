<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;

class RhUserController extends Controller
{
    public function index(): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $colaborators = User::where('role', 'rh')->get();

        return view('colaborator.colaborators', compact('colaborators'));
    }

    public function add_rh_colaborator(): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $departments = Department::all();
        
        return view('colaborator.add_rh_colaborator', compact('departments'));
    }

    public function create_rh_colaborator(Request $request)// : View | RedirectResponse 
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $department = $this->decrypt($request->department);

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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
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

        return redirect()->route('rh_colaborators');
    }

    private function decrypt($value)
    {
        try {
            $value = Crypt::decrypt($value);
            return $value;
        } catch (\Exception $e) {
            return false;
        }
    }
}
