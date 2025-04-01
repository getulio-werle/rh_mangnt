<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ColaboratorsController extends Controller
{
    public function colaborators()
    {
        if (!Gate::allows('admin')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $colaborators = User::with('details', 'department')
                        ->where('role', '!=', 'admin')
                        ->get();

        return view('colaborators.admin-all-colaborators')->with('colaborators', $colaborators);
    }
}
