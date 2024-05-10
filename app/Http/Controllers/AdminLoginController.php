<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function Login()
    {
        return View('admin.login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            return redirect()->route('AdminDashboard');
        } else {
            Session::flash('error-msg', 'Invalid email or password');
            return redirect()->back();
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login_page');
    }
}
