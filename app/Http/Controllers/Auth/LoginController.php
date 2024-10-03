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

            // kullanıcı login olduğu sırada remember'ı da yolluyoruz.
            Auth::login($user,$remember);
            return redirect()->route("admin.index");
            // veya durum kontrol burada olur
            // return redirect()->where('status',1)->where('isAdmin',1)->route("admin.index");

        } else {
            return redirect()
                ->route("login")
                ->withErrors([
                    'email' => "kullanıcı bulunamadı",
                ])
                ->onlyInput("email", "remember");
        }
    }

    public function login2(LoginRequest $request){
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;
        !is_null($remember) ? $remember = true : $remember = false;

        if(Auth::attempt(['email'=>$email,'password'=>$password],$remember )){
            // user login oldu

            // session değiştirelim
            return redirect()->route("admin.index");
        }else {
            return redirect()
                ->route("login")
                ->withErrors([
                    'email' => "kullanıcı bulunamadı",
                ])
                ->onlyInput("email", "remember");
        }
    }

    public function login3(LoginRequest $request){
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;
        !is_null($remember) ? $remember = true : $remember = false;

        // kullanıcı tablosunda status'u 1 olanları login yap.
        // aktiflik ve adminlik durum kontrolü yaptırırız
        if(Auth::attempt(['email'=>$email,'password'=>$password,'status'=>1],$remember )){
            // user login oldu

            // session değiştirelim
            
            return redirect()->route("admin.index");
        }else {
            return redirect()
                ->route("login")
                ->withErrors([
                    'email' => "kullanıcı bulunamadı",
                ])
                ->onlyInput("email", "remember");
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
    function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
