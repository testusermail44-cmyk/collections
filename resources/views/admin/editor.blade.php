@extends('layouts.app')
@section('title', "Редактор категорій")
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 shadow shadow-gray-600/60 rounded-xl">
    <h2 class="text-2xl font-bold uppercase tracking-tighter">
        {{ isset($category) ? 'Редагувати' : 'Створити' }} категорію
    </h2>
    <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if(isset($category)) @method('PUT') @endif
        <div class="space-y-2">
            <label class="text-gray-500 text-lg">Назва категорії</label>
            <input type="text" name="name" class="input-main w-full" 
                   value="{{ old('name', $category->name ?? '') }}" required autofocus>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mt-8 flex gap-3">
            <button type="submit" class="btn-primary flex-1">Зберегти</button>
        </div>
    </form>
</div>
@endsection