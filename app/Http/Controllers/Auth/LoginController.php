<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function showLogin() {
        return view('auth.login');
    }
    function login(Request $request) {
        dd($request->all());
        return view('auth.login');
    }
    function showRegister() {
        return view('auth.register');
    }
    function register() {
        return view('auth.register');
    }
}
