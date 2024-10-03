<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    function showLogin()
    {
        return view('auth.login');
    }
    function login(LoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        $user = User::where('email', $email)->first();
            
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect()->route("admin.index");
        }    
        else {
            return redirect()
                ->route("login")
                ->withErrors([
                    'email'=> "kullanıcı bulunamadı",
                ])
                ->onlyInput("email","remember");
        }
    }
    function showRegister()
    {
        return view('auth.register');
    }
    function register()
    {
        return view('auth.register');
    }
}
