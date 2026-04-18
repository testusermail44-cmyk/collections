@extends('layouts.app')

@section('title', 'Головна')

@section('content')
<div class="space-y-20 pb-20">
    {{-- 1. HERO SECTION --}}
    <section class="relative py-16 md:py-28 overflow-hidden">
        {{-- Декоративні фонові градієнти --}}
        <div class="absolute top-0 -left-10 w-72 h-72 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

        <div class="max-w-6xl mx-auto px-6 text-center relative">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-black uppercase tracking-widest text-cyan-700 bg-cyan-100 rounded-full">
                Твій цифровий архів
            </span>
            <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 leading-[1.1]">
                Зберігай історію <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-500">кожного предмета</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Систематизуйте свої знахідки, створюйте естетичні галереї та діліться своїм захопленням зі світом. Від кераміки до коду.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('collections.create') }}" class="btn-primary w-full sm:w-auto px-10 py-4 text-xl shadow-xl shadow-cyan-600/30">
                    Створити колекцію
                </a>
                <a href="#explore" class="w-full sm:w-auto px-10 py-4 rounded-2xl font-bold text-gray-600 bg-white border border-gray-100 hover:bg-gray-50 transition-all text-center">
                    Переглянути галерею
                </a>
            </div>
        </div>
    </section>

    <section id="explore" class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-black text-gray-800">Досліджуйте світ</h2>
                <p class="text-gray-500">Знайдіть те, що надихає вас найбільше</p>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <div class="group relative h-40 rounded-3xl overflow-hidden bg-gray-200 shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center text-4xl">
                    <img src="{{ asset('images/coins.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-4 left-4 z-20">
                    <span class="text-white font-bold text-lg">Монети</span>
                </div>
            </div>
            <div class="group relative h-40 rounded-3xl overflow-hidden bg-gray-200 shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center text-4xl">
                    <img src="{{ asset('images/banknotes.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-4 left-4 z-20">
                    <span class="text-white font-bold text-lg">Банкноти</span>
                </div>
            </div>
            <div class="group relative h-40 rounded-3xl overflow-hidden bg-gray-200 shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center text-4xl">
                    <img src="{{ asset('images/marks.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-4 left-4 z-20">
                    <span class="text-white font-bold text-lg">Марки</span>
                </div>
            </div>
            <div class="group relative h-40 rounded-3xl overflow-hidden bg-gray-200 shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center text-4xl">
                    <img src="{{ asset('images/figures.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-4 left-4 z-20">
                    <span class="text-white font-bold text-lg">Фігурки</span>
                </div>
            </div>
            <div class="group relative h-40 rounded-3xl overflow-hidden bg-gray-200 shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center text-4xl">
                    <img src="{{ asset('images/books.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-4 left-4 z-20">
                    <span class="text-white font-bold text-lg">Книги</span>
                </div>
            </div>
        </div>
    </section>
    <section class="max-w-6xl mx-auto px-6">
        <div class="bg-cyan-600 rounded-[3rem] p-10 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-cyan-900/20">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Готові розпочати власну історію?</h2>
                <p class="text-cyan-100 text-lg mb-10 max-w-xl mx-auto opacity-90">
                    Приєднуйтесь до спільноти колекціонерів та створіть свій перший каталог вже сьогодні.
                </p>
                <a href='/auth/registration' class="inline-block bg-white text-cyan-600 px-12 py-4 rounded-2xl font-black text-xl hover:bg-cyan-50 transition-colors">
                    Зареєструватися
                </a>
            </div>
        </div>
    </section>
</div>
@endsection