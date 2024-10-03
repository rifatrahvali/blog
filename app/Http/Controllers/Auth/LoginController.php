<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function showLogin() {
        return view('auth.login');
    }
    function login() {
        return view('auth.login');
    }
}
