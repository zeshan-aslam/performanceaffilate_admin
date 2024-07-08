<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class ChangePasswordController extends Controller
{
    function changePasswordForm(){

        return view('auth.passwords.change');
    }
    function changePassword(Request $request){
        $request->validate([
            'oldpassword' => 'required|min:8',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',

        ]);
        if (Hash::check($request->oldpassword, Auth::user()->password)) {
            $user =Auth::user();
            $user->password=Hash::make($request->password);
            $user->update();

              return "Matched";

        }


    }
}
