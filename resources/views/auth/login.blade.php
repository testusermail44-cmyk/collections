@extends('layouts.app')
@section('title', 'Вхід')
@section('content')
    <form class="mx-auto max-w-md flex flex-col gap-5 px-10 py-10 shadow shadow-gray-600/60 rounded-xl" method="post" action="login">
        @csrf    
        <label for="email" class="text-gray-500 text-lg">Введіть Email</label>
        <input id="email" class="input-main" type="text" placeholder="Email" name="email" required value="{{ old('email') }}"/>
        <label for="pass" class="text-gray-500 text-lg">Введіть пароль</label>
        <input id='pass' class="input-main" type="password" placeholder="Пароль" name="password" required/>
        <label class="flex items-center cursor-pointer group">
            <div class="relative">
                <input type="checkbox" name="remember" class="checkbox peer">
                <div class="checkbox-tile"></div>
            </div>
            <span class="ml-3 text-gray-700 text-lg select-none group-hover:text-cyan-600 transition-colors">
                Запам'ятати мене
            </span>
        </label>
        <button class="btn-primary" type="submit">Увійти</button>
        <a href="registration" class="text-center text-lg text-blue-500">Зареєструватися</a>
    </form>
@endsection