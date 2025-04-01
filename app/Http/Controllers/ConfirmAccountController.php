<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('auth.account-confirmation', compact('user'));
    }

    public function confirmAccountSubmit(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);

        $user = User::where('confirmation_token', $request->token)->first();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $user->password = bcrypt($request->password);
        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return view('auth.welcome', compact('user'));
    }
}
