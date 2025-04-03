<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class ColaboratorsController extends Controller
{
    public function colaborators() : View | RedirectResponse
    {
        if (!Gate::allows('admin', 'rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        // $colaborators = User::with('details', 'department')
        //                 ->where('role', '!=', 'admin')
        //                 ->get();

        $colaborators = User::withTrashed()
                        ->with(['details' => function (Builder $query) {
                            $query->withTrashed();
                        }])
                        ->where('role', '!=', 'admin')
                        ->get();

        return view('colaborators.admin-all-colaborators')->with('colaborators', $colaborators);
    }

    public function colaboratorDetails($id) : View | RedirectResponse
    {
        if (!Gate::allows('admin', 'rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);

        return view('colaborators.colaborator-details')->with('colaborator', $colaborator);
    }

    public function deleteColaborator($id) : View | RedirectResponse
    {
        if (!Gate::allows('admin', 'rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-colaborator-confirm')->with('colaborator', $colaborator);
    }

    public function deleteColaboratorConfirm($id) : RedirectResponse
    {
        if (!Gate::allows('admin', 'rh')) {
            return abort(403, 'You are not authorized to access this page');
        }

        $id = $this->decrypt($id);

        if (!$id) {
            return redirect()->back();
        }

        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);
        $colaborator_details = UserDetail::where('user_id', $id);
        $colaborator_details->delete();
        $colaborator->delete();

        return redirect()->route('colaborators');
    }

    public function restoreColaborator($id) : RedirectResponse
    {
        if (!Gate::allows('admin', 'rh')) {
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
