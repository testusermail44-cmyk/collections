@extends('layouts.app')
@section('title', 'Налаштування')
@section('content')
    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white backdrop-blur-sm shadow shadow-gray-600/60 rounded-xl rounded-3xl overflow-hidden">
            <div class="p-8 border-b border-gray-100">
                <h1 class="text-2xl font-black text-gray-800">Налаштування профілю</h1>
                <p class="text-gray-500 text-sm">Керуйте вашими персональними даними та аватаркою</p>
            </div>

            <form action="{{ route('user.update') }}" method="POST" id="profile-form" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <img id="avatar-preview" src="{{ auth()->user()->avatar_url }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md">
                        <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                            <span class="text-white text-xs font-bold">Змінити</span>
                        </div>
                        <input type="file" id="avatar-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-700">Ваше фото</h3>
                        <p class="text-xs text-gray-400" id="upload-status">Дозволені формати: JPG, PNG. До 2 Мб.</p>
                    </div>
                </div>

                <input type="hidden" name="avatar_url" id="avatar-url-hidden" value="{{ old('avatar_url') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-gray-500 text-lg">Ім'я</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-main w-full">
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-lg">Прізвище</label>
                        <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="input-main w-full">
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
                        <input type="password" name="password_confirmation" class="input-main w-full" placeholder="Повторіть пароль">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submit-btn" class="btn-primary w-full py-3 rounded-2xl shadow-lg shadow-cyan-600/20">
                        Зберегти зміни
                    </button>
                </div>
            </form>

            <div class="px-8 py-4 bg-gray-50/50 rounded-b-3xl border-t border-gray-100 text-center">
                <p class="text-[11px] text-gray-400 uppercase tracking-widest font-bold">
                    Зареєстровано: {{ $user->created_at->format('d.m.Y') }}
                </p>
            </div>
        </div>
    </div>

    <script>
        const IMGBB_KEY = '{{ env('IMGBB_API_KEY') }}';
        const avatarInput = document.getElementById('avatar-input');
        const uploadStatus = document.getElementById('upload-status');
        const submitBtn = document.getElementById('submit-btn');
        const avatarUrlHidden = document.getElementById('avatar-url-hidden');

        avatarInput.addEventListener('change', async function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);

            submitBtn.disabled = true;
            uploadStatus.textContent = 'Завантаження картинки на сервер...';
            uploadStatus.style.color = '#3b82f6';

            try {
                const base64 = await toBase64(file);
                const formData = new FormData();
                formData.append('image', base64.split(',')[1]);

                const res = await fetch('https://api.imgbb.com/1/upload?key=' + IMGBB_KEY, {
                    method: 'POST',
                    body: formData,
                });
                const data = await res.json();

                if (data && data.data && data.data.url) {
                    avatarUrlHidden.value = data.data.url;
                    uploadStatus.textContent = 'Картинку успішно завантажено';
                    uploadStatus.style.color = '#10b981';
                } else {
                    uploadStatus.textContent = 'Помилка при завантаженні';
                    uploadStatus.style.color = '#ef4444';
                }
            } catch (err) {
                uploadStatus.textContent = 'Помилка мережі при завантаженні.';
                uploadStatus.style.color = '#ef4444';
                console.error(err);
            } finally {
                submitBtn.disabled = false;
            }
        });

        function toBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
