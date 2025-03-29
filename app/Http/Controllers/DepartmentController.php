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
    public function departments(): View
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $departments = Department::all();

        return view('department.departments', compact('departments'));
    }

    public function add_department(): View
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        return view('department.add-department');
    }

    public function create_department(Request $request): RedirectResponse
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

    public function edit_department($id): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (intval($id) == 1) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.edit-department', compact('department'));
    }

    public function alter_department(Request $request): RedirectResponse
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

        if (intval($id) == 1) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name
        ]);

        return redirect()->route('departments');
    }

    public function delete_department($id): View | RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (intval($id) == 1) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.delete_department', compact('department'));
    }

    public function delete_department_confirm($id): RedirectResponse
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }
        
        if (intval($id) == 1) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()->route('departments');
    }

    private function decrypt($valor)
    {
        try {
            $valor = Crypt::decrypt($valor);
            return $valor;
        } catch (\Exception $e) {
            return false;
        }
    }
}
