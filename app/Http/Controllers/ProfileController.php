<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('user.settings', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $messages = [
            'email'             => 'Введіть коректну адресу пошти',
            'email.unique'      => 'Цей емейл вже зайнятий',
            'password.min'      => 'Пароль має бути не менше 8 символів',
            'password.confirmed'=> 'Паролі не збігаються',
            'avatar_url.url'    => 'Некоректний формат посилання на аватар',
            'name.required'     => 'Введіть ім\'я',
            'lastname.required' => 'Введіть прізвище',
            'email.required'    => 'Введіть email',
        ];

        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'lastname'   => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'avatar_url' => 'nullable|url', 
            'password'   => 'nullable|min:8|confirmed',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('type', 1);
        }

        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('avatar_url')) {
            $user->avatar_url = $request->avatar_url;
        }

        $user->save();

        return back()->with('success', 'Профіль успішно оновлено!')->with('type', 2);
    }
}
