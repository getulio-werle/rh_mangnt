<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function departments() : View
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $departments = Department::all();

        return view('departments.departments', compact('departments'));
    }

    public function addDepartment() : View
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        return view('departments.add-department');
    }

    public function createDepartment(Request $request) : RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $request->validate(
            [
                'name' => 'required|unique:departments,name'
            ]
        );

        Department::create([
            'name' => $request->name
        ]);

        return redirect()->route('departments');
    }

    public function editDepartment($id) : View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if ($this->is_department_blocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('departments.edit-department', compact('department'));
    }

    public function alterDepartment(Request $request) : RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $request->validate(
            [
                'id' => 'required',
                'name' => 'required|max:50|unique:departments,name'
            ]
        );

        $id = $this->decrypt($request->id);

        if (!$id) {
            return redirect()->back();
        }

        if ($this->is_department_blocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name
        ]);

        return redirect()->route('departments');
    }

    public function deleteDepartment($id) : View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if ($this->is_department_blocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('departments.delete-department', compact('department'));
    }

    public function deleteDepartmentConfirm($id) : RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }
        
        if ($this->is_department_blocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()->route('departments');
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

    private function is_department_blocked($id) : bool
    {
        return in_array(intval($id), [1, 2]);
    }
}
