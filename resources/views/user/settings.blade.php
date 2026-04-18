@extends('layouts.app')
@section('title', 'Налаштування')
@section('content')
    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white backdrop-blur-sm shadow shadow-gray-600/60 rounded-xl rounded-3xl overflow-hidden">
            <div class="p-8 border-b border-gray-100">
                <h1 class="text-2xl font-black text-gray-800">Налаштування профілю</h1>
                <p class="text-gray-500 text-sm">Керуйте вашими персональними даними та аватаркою</p>
            </div>

            <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <img id="avatar-preview" src="{{ auth()->user()->avatar_url }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md">
                        <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                            <span class="text-white text-xs font-bold">Змінити</span>
                        </div>
                        <input type="file" name="avatar" accept="image/*" onchange="previewImage(this)" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-700">Ваше фото</h3>
                        <p class="text-xs text-gray-400">Дозволені формати: JPG, PNG. До 2 Мб.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-gray-500 text-lg">Ім'я</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-main w-full">
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-lg">Прізвище</label>
                        <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                            class="input-main w-full">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-gray-500 text-lg">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-main w-full">
                </div>

                <hr class="border-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-gray-500 text-lg">Новий пароль</label>
                        <input type="password" name="password" class="input-main w-full" placeholder="Пароль">
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-lg">Підтвердження</label>
                        <input type="password" name="password_confirmation" class="input-main w-full"
                            placeholder="Повторіть пароль">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-primary w-full py-3 rounded-2xl shadow-lg shadow-cyan-600/20">
                        Зберегти зміни
                    </button>
                </div>
            </form>

            {{-- Твій напівпрозорий клас із заокругленням тільки знизу --}}
            <div class="px-8 py-4 bg-gray-50/50 rounded-b-3xl border-t border-gray-100 text-center">
                <p class="text-[11px] text-gray-400 uppercase tracking-widest font-bold">
                    Зареєстровано: {{ $user->created_at->format('d.m.Y') }}
                </p>
            </div>
        </div>
    </div>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection