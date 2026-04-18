<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            'email'    => 'Введіть коректну адресу пошти',
            'email.unique'   => 'Цей емейл вже зайнятий',
            'password.min'      => 'Пароль має бути не менше 8 символів',
            'password.confirmed'=> 'Паролі не збігаються',
            'avatar.max'=> 'Фото має бути не більше 2 Мб',
            'name.required'=> 'Введіть ім\'я',
            'lastname.required'=> 'Введіть прізвище',
            'email.required'=> 'Введіть email',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|max:2048', 
            'password' => 'nullable|min:8|confirmed',
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
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload', [
                'key' => env('IMGBB_API_KEY'),
                'image' => base64_encode(file_get_contents($image->getRealPath())),
            ]);
            if ($response->successful()) {
                $data = $response->json()['data'];
                $user->avatar_url = $data['url'];
            }
        }
        $user->save();
        return back()->with('success', 'Профіль успішно оновлено!')->with('type', 2);
    }
}
?>