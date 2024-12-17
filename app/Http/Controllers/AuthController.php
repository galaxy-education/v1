<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // دالة التسجيل
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users',
            'phone_number' => 'nullable|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/home');
    }
    // دالة تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required|string',
        ]);

        // تحديد ما إذا كان المدخل بريدًا إلكترونيًا أم رقم هاتف
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            return redirect('/home');
        }

        return back()->withErrors(['login' => 'تأكد من بيانات الدخول وحاول مرة أخرى.']);
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
