@extends('layouts.app')
@section('title', 'Колекції')
@section('content')
    @if(!$isMyCollections)
        <div class="bg-white">
            <form action="{{ route('collections.show') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full space-y-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Пошук</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Назва колекції або опис..." class="input-main">
                </div>
                <div class="w-full md:w-48 space-y-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Категорія</label>
                    <select name="category" class="input-main appearance-none w-full bg-no-repeat bg-right"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23718096%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3E%3Cpolyline points=%276 9 12 15 18 9%27%3E%3C/polyline%3E%3C/svg%3E'); background-position: right 0.75rem center; background-size: 1.2em;">
                        <option value="0">Категорія</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary">
                        Знайти
                    </button>
                    @if(request()->anyFilled(['search', 'category']))
                        <a href="{{ route('collections.show') }}" class="btn-primary bg-red-400">Скинути</a>
                    @endif
                </div>
            </form>
        </div>
    @else
        <div class="flex justify-between items-center border-b-2 border-cyan-600 pb-2 mb-8">
            <h1 class="text-3xl font-black text-gray-800">Мої колекції</h1>
        </div>
    @endif
    <div class="py-4 {{ $isMyCollections ? 'flex flex-row' :  'grid grid-cols-1 lg:grid-cols-2' }} gap-4 items-center justify-center">
        @if (count($publicCollections) == 0)
            <div class="flex flex-col items-center gap-6">
                <div class="relative w-[150px] h-[150px] rounded-full border-4 border-cyan-600 bg-cyan-200 flex flex-col items-center justify-center">
                    <div class="flex flex-row gap-5 mb-4">
                        <div class="rounded-full w-10 h-10 bg-white border-4 border-cyan-600 flex items-center justify-center overflow-hidden">
                            <div class="bg-black w-4 h-4 mt-3 rounded-full"></div>
                        </div>
                        <div class="rounded-full w-10 h-10 bg-white border-4 border-cyan-600 flex items-center justify-center overflow-hidden">
                            <div class="bg-black w-4 h-4 mt-3 rounded-full"></div>
                        </div>
                    </div>
                    <div class="w-[75px] h-[32px] border-t-4 border-cyan-600 rounded-t-full"></div>
                </div>
                <div class="text-3xl font-bold text-cyan-600 tracking-tight">
                    {{ $isMyCollections ? 'Ви ще не створили жодної колекції' : 'Такої колекції ще не існує' }}</div>
            </div>
        @endif
        @foreach($publicCollections as $collection)
            <div class="relative group w-full">
            @if($isMyCollections)
                <div class="w-full bg-gray-700/50 absolute top-0 left-0 px-4 py-2 rounded-t-xl z-20 flex gap-2 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('items.create', ['collection' => $collection->id]) }}"class="flex items-center justify-center w-20 h-20 lg:w-10 lg:h-10 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110" title="Додати експонат">
                        <span class="text-xl">+</span>
                    </a>
                    <a href="{{ route('collections.edit', $collection->id) }}" class="w-20 h-20 lg:w-10 lg:h-10 bg-amber-500 hover:bg-amber-600 text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110" title="Редагувати колекцію">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>
                    <form action="{{ route('collections.destroy', $collection->id) }}" method="POST">
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
            @endif
            <a href="{{ route($isMyCollections ? 'collections.elements.my' : 'collections.elements', $collection->id) }}" class="flex flex-col flex-1 gap-3 items-stretch sm:h-auto md:h-64 md:flex-row px-2 py-2 bg-white overflow-hidden shadow shadow-gray-600/60 rounded-xl">
                <div class="p-1 rounded-xl bg-cyan-100 w-full md:w-80 lg:w-[250px] h-full bg-gray-50 relative shrink-0 flex flex-row items-center justify-center">
                    @php
                        $allImages = $collection->items->flatMap(function ($item) {
                            return $item->images;
                        })->pluck('url')->take(3);
                    @endphp
                    @if($allImages->count() >= 3)
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2 flex items-center">
                                <img src="{{ $allImages[0] }}" class="rounded-xl lg:w-120 flex-1 object-cover">
                            </div>
                            <div class="flex flex-col gap-1 h-full justify-center">
                                <img src="{{ $allImages[1] }}" class="rounded-xl lg:w-75 flex-1 object-cover">
                                <img src="{{ $allImages[2] }}" class="rounded-xl lg:w-75 flex-1 object-cover">
                            </div>
                        </div>
                    @elseif($allImages->count() > 0)
                        <img src="{{ $allImages[0] }}" class="rounded-xl lg:w-120 h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400">
                            <span class="text-4xl mb-2">📦</span>
                            <span class="text-xs font-semibold uppercase tracking-widest">Немає фото</span>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <span class="w-full text-[14px] font-semibold text-gray-400">Категорія:
                            {{ $collection->category->name }}</span>
                        <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-tighter">
                            {{ $collection->created_at->format('d.m.Y') }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold w-full border-b-2 pb-1 border-b-cyan-600 text-gray-800 leading-tight">
                        {{ $collection->title }}
                    </h2>
                    <p class="text-sm text-gray-500 line-clamp-3 mb-6 flex-1">
                        {{ $collection->description }}
                    </p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <img src="{{ $collection->user->avatar_url }}" class="w-9 h-9 rounded-full border-2 border-cyan-500 object-cover shadow-sm">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-700 leading-none">
                                    {{ $collection->user->name }} {{ $collection->user->lastname }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
        @endforeach
    </div>
@endsection