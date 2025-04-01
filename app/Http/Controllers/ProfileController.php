<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function profile() : View
    {
        return view('user.profile');
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

        return redirect()->back()->with(['success_change_data' => 'Profile updated successfully']);
    }
}
