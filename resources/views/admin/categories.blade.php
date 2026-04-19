@extends('layouts.app')
@section('title', "Редактор категорій")
@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 shadow shadow-gray-600/60 rounded-xl mb-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold uppercase tracking-tighter">Керування категоріями</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">Додати категорію</a>
        </div>
        <div class="space-y-3">
            @foreach($categories as $category)
                <div
                    class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-cyan-200 transition-all">
                    <span class="font-bold text-gray-700">{{ $category->name }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                            class="w-20 h-20 lg:w-10 lg:h-10 bg-amber-500 hover:bg-amber-600 text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110"
                            title="Редагувати колекцію">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-20 h-20 lg:w-10 lg:h-10 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110"
                                title="Видалити">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection