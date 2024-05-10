<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentLoginController extends Controller
{
    //
    public function Login()
    {
        return View('student.login');
    }

    public function studentLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->route('studentDashboard');
        } else {
            Session::flash('error-msg', 'Invalid email or password');
            return redirect()->back();
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect()->route('welcome');
    }
}
