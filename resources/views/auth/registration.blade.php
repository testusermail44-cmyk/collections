@extends('layouts.app')
@section('title', 'Вхід')
@section('content')
    <form class="mx-auto max-w-md flex flex-col gap-5 px-10 py-10 shadow shadow-gray-600/60 rounded-xl" method="post" action="registration">
        @csrf    
        <label for="name" class="text-gray-500 text-lg">Введіть ім'я</label>
        <input id="name" class="input-main" type="text" placeholder="Ім'я" name="name" required value="{{ old('name') }}"/>
        <label for="last" class="text-gray-500 text-lg">Введіть прізвище</label>
        <input id="last" class="input-main" type="text" placeholder="Прізвище" name="last" required value="{{ old('last') }}"/>
        <label for="email" class="text-gray-500 text-lg">Введіть Email</label>
        <input id="email" class="input-main" type="text" placeholder="Email" name="email" required value="{{ old('email') }}"/>
        <label for="pass" class="text-gray-500 text-lg">Введіть пароль</label>
        <input id='pass' class="input-main" type="password" placeholder="Пароль" name="password" required value="{{ old('password') }}"/>
        <label for="conf" class="text-gray-500 text-lg">Повторіть пароль</label>
        <input id='conf' class="input-main" type="password" placeholder="Пароль" name="password_confirmation" required value="{{ old('password_confirmation') }}"/>
        <button class="btn-primary" type="submit">Зареєструватись</button>
        <a href="login" class="text-center text-lg text-blue-500">Увійти</a>
    </form>
@endsection