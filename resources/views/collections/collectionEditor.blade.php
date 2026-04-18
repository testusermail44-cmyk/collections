@extends('layouts.app')
@section('title', 'Редактор')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 shadow shadow-gray-600/60 rounded-xl">
            <h1 class="text-2xl font-bold mb-6">Створити нову колекцію</h1>
            <form
                action="{{ isset($collection) ? route('collections.update', $collection->id) : route('collections.store') }}"
                method="POST">
                @csrf
                @if(isset($collection))
                    @method('PUT')
                @endif
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Назва колекції</label>
                    <input type="text" name="title" value="{{ old('title', $collection->title ?? '') }}" class="input-main"
                        placeholder="Назва колекції">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Категорія</label>
                    <select name="category_id" class="input-main appearance-none bg-no-repeat bg-right"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23718096%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3E%3Cpolyline points=%276 9 12 15 18 9%27%3E%3C/polyline%3E%3C/svg%3E'); background-position: right 0.75rem center; background-size: 1.2em;">
                        <option value="" disabled {{ !isset($collection) ? 'selected' : '' }}>Оберіть категорію</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $collection->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Опис (необов'язково)</label>
                    <textarea name="description" rows="4" class="input-main resize-none">{{ old('description', $collection->description ?? '') }}</textarea>
                </div>
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_public" class="checkbox peer" value="1" {{ old('is_public', $collection->is_public ?? true) ? 'checked' : '' }}>
                        <div class="checkbox-tile"></div>
                    </div>
                    <span class="ml-3 text-gray-700 text-lg select-none group-hover:text-cyan-600 transition-colors">Зробити
                        колекцію публічною</span>
                </label>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Зберегти колекцію</button>
                </div>
            </form>
        </div>
    </div>
@endsection