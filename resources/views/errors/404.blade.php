@extends('layouts.app')
@section('title', 'Сторінку не знайдено — 404')
@section('content')
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <h1 class="text-9xl font-bold text-cyan-600">404</h1>
        <p class="text-2xl md:text-3xl font-medium mt-4 text-gray-800">
            Упс! Колекція загубилася...
        </p>
        <p class="text-gray-500 mt-2 mb-8">
            Схоже, такої сторінки не існує або її було перенесено.
        </p>
        <a href="/" class="bg-cyan-600 hover:bg-cyan-400 transition-all duration-300 bg-opacity-100 rounded-xl px-8 py-3 text-white text-lg font-semibold shadow-lg hover:shadow-cyan-500/30">
            Повернутися на головну
        </a>
        <div class="mt-12 opacity-20">
            <i class="fas fa-search-minus text-8xl"></i>
        </div>
    </div>
@endsection