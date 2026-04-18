@extends('layouts.app')

@section('title', $collection->title)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="border-b border-gray-100 pb-6 mb-8 flex flex-col md:flex-row justify-between items-start gap-6">
            <div class="flex-1">
                <h1 class="text-4xl font-black text-gray-900">{{ $collection->title }}</h1>
                <p class="text-gray-500 mt-2 max-w-3xl leading-relaxed">{{ $collection->description }}</p>
                <div class="mt-4 flex items-center gap-4 text-sm text-gray-400 font-medium">
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <b>{{ $collection->user->name }} {{ $collection->user->lastname }}</b>
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $collection->created_at->format('d.m.Y') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($items as $item)
                <div
                    class="relative group bg-white border border-gray-100 shadow-xl shadow-gray-200/50 rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-cyan-600/10 transition-all duration-300">

                    @if($isMyCollection)
                        <div class="w-full bg-gray-700/50 absolute top-0 left-0 px-4 py-2 rounded-t-xl z-20 flex gap-2 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('items.edit', $item->id) }}"
                                class="w-20 h-20 lg:w-10 lg:h-10 bg-amber-500 hover:bg-amber-600 text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110"
                                title="Редагувати колекцію">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST">
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

                    <a href="{{ route('collection.item', $item->id) }}" class="block">
                        <div class="h-56 w-full bg-gray-50 overflow-hidden relative">
                            @php $firstImage = $item->images->first(); @endphp
                            @if($firstImage)
                                <img src="{{ $firstImage->url }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-black text-gray-800 text-lg truncate mb-2">{{ $item->name }}</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">
                                    {{ $item->created_at->format('M Y') }}
                                </span>
                                @if($item->condition)
                                    <span
                                        class="text-[11px] px-3 py-1 bg-cyan-50 text-cyan-700 rounded-lg font-black uppercase tracking-tighter border border-cyan-100">
                                        {{ $item->condition == 1 ? "Ідеальний" : ($item->condition == 2 ? "Гарний" : ( $item->condition == 3 ? "Середній" : "Поганий")) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div
                    class="col-span-full py-24 text-center bg-gray-50/50 rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center text-4xl mb-6">📦
                        </div>
                        <h2 class="text-2xl font-black text-gray-800">Тут поки порожньо</h2>
                        <p class="text-gray-400 mt-2">Час додати перший експонат до вашої колекції!</p>
                        @if($isMyCollection)
                            <a href="{{ route('items.create', ['collection' => $collection->id]) }}"
                                class="mt-6 btn-primary px-8 py-3 rounded-2xl">
                                Додати предмет
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $items->links() }}
        </div>
    </div>
@endsection