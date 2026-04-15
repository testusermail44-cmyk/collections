<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
class registrationController extends Controller
{
    function register(Request $request)
    {
        $messages = [
            'email.email'    => 'Введіть коректну адресу пошти',
            'email.unique'   => 'Цей емейл вже зайнятий',
            'password.min'      => 'Пароль має бути не менше 8 символів',
            'password.confirmed'=> 'Паролі не збігаються',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ], $messages);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('type', 1);
        }

        User::create([
            'name'     => $request->name,
            'lastname' => $request->last,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
        ]);
        
        return redirect('auth/login')->with('success', 'Акаунт успішно створено!')->with('type', 2);
    }
}
?>