<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    protected $redirectTo = '/';

    public function login()
    {
        return view('auths.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginProcess(Request $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (Auth::check()) {            
            return redirect(route('dashboard'));
        }
        return redirect(route('login'))->with('NotFound', 'Email / Password tidak diketahui');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
