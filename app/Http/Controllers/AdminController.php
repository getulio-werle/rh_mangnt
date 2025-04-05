<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function home()
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $data = [];

        $data['total_colaborators'] = User::withoutTrashed()->count();

        $data['total_colaborators_deleted'] = User::onlyTrashed()->count();

        $data['total_salary'] = User::withoutTrashed()
            ->with('details')
            ->get()
            ->sum(function ($colaborator) {
                return $colaborator->details->salary;
            });

        $data['total_salary'] = number_format($data['total_salary'], 2, ',', '.') . '$';

        $data['total_colaborators_per_department'] = User::withoutTrashed()
            ->with('details')
            ->get()
            ->groupBy('department_id')
            ->map(function ($department) {
                return [
                    'department' => $department->first()->department->name ?? '-',
                    'total' => $department->count()
                ];
            });

        $data['total_salary_by_department'] = User::withoutTrashed()
            ->with('details')
            ->get()
            ->groupBy('department_id')
            ->map(function ($department) {
                return [
                    'department' => $department->first()->department->name ?? '-',
                    'total' => $department->sum(function ($colaborator) {
                        return $colaborator->details->salary;
                    })
                ];
            });
            
        $data['total_salary_by_department'] = $data['total_salary_by_department']->map(function ($department) {
            return [
                'department' => $department['department'],
                'total' => number_format($department['total'], 2, ',', '.') . '$'
            ];
        });

        return view('home')->with('data', $data);
    }
}
