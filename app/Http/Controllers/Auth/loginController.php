<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class loginController extends Controller
{
    function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->has('remember'))){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        else {
            return back()
            ->withInput()
            ->withErrors(['auth' => 'Невірний логін або пароль'])
            ->with('type', 1);
        }
    }

}
?>