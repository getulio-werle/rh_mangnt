<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function profile() : View
    {
        $colaborator = User::with('details')
                        ->findOrFail(Auth::user()->id);

        return view('user.profile')->with('colaborator', $colaborator);
    }

    public function updatePassword(Request $request) : RedirectResponse
    {
        $request->validate(
            [
                'current_password' => 'required|min:8|max:255',
                'new_password' => 'required|min:8|max:255|different:current_password',
                'new_password_confirmation' => 'required|same:new_password',
            ]
        );

        $user = auth()->user();

        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->with([
                'error_change_password' => 'Incorrect password'
            ]);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with([
            'success_change_password' => 'Password updated successfully'
        ]);
    }

    public function updateData(Request $request) : RedirectResponse 
    {
        $request->validate(
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . auth()->id()
            ]
        );

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with(['success_change_data' => 'Data updated successfully']);
    }

    public function updateAddress(Request $request) : RedirectResponse
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
        ]);

        $colaborator = User::with('details')
                            ->findOrFail(Auth::user()->id);
        $colaborator->details->address = $request->address;
        $colaborator->details->zip_code = $request->zip_code;
        $colaborator->details->city = $request->city;
        $colaborator->details->phone = $request->phone;
        $colaborator->details->save();

        return redirect()->back()->with(['success_change_address' => 'Address updated successfully']);
    }
}
