@extends('layouts.app')
@section('title', $item->name)
@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row gap-10">
            <div class="w-full md:w-1/2">
                <div class="aspect-square rounded-3xl overflow-hidden border-4 border-white shadow-2xl bg-gray-50 mb-4">
                    @if($item->images->count() > 0)
                        <img id="main-item-photo" src="{{ $item->images->first()->url }}"
                            class="w-full h-full object-contain p-2 transition-opacity duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300 text-6xl">📦</div>
                    @endif
                </div>

                @if($item->images->count() > 1)
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        @foreach($item->images as $img)
                            <button onclick="document.getElementById('main-item-photo').src='{{ $img->url }}'"
                                class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent hover:border-cyan-600 focus:border-cyan-600 transition-all">
                                <img src="{{ $img->url }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="w-full md:w-1/2">
                <div class="mb-2">
                    <span
                        class="px-2 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase rounded tracking-widest border border-gray-200">
                        ID: #{{ $item->id }}
                    </span>
                </div>

                <h1 class="text-4xl font-black text-gray-900 mb-4 leading-tight">{{ $item->name }}</h1>

                <div class="h-1.5 w-20 bg-cyan-600 rounded-full mb-8"></div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="p-4 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                        <p class="text-[10px] text-cyan-600 font-bold uppercase mb-1">Стан предмета</p>
                        <p class="text-lg font-bold text-cyan-900">{{ $item->condition ?? 'Не вказано' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Дата додавання</p>
                        <p class="text-lg font-bold text-gray-700">{{ $item->created_at->format('d.m.Y') }}</p>
                    </div>
                </div>

                <div class="mb-10">
                    <h3 class="text-sm font-bold text-gray-400 uppercase mb-3 tracking-widest">Опис експоната</h3>
                    <div class="prose prose-cyan text-gray-600 leading-relaxed">
                        {{ $item->description ?: 'Опис для цього предмета ще не додано.' }}
                    </div>
                </div>

                <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="shrink-0">
                            <img src="{{ $item->collection->user->avatar_url }}"
                                class="w-12 h-12 object-cover rounded-full border-2 border-cyan-500 shadow-sm">
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Колекціонер</p>
                            <p class="text-sm font-bold">{{ $item->collection->user->name }}
                                {{ $item->collection->user->lastname }}</p>
                        </div>
                    </div>
                    <a href="{{ route('collections.elements', $item->collection->id) }}"
                        class="text-xs font-bold text-cyan-600 hover:text-cyan-700 underline decoration-2 underline-offset-4">
                        Вся колекція →
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-16 max-w-4xl">
        <h3 class="text-2xl font-bold mb-8 flex items-center gap-2">
            <span>Коментарі</span>
            <span class="text-sm bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $item->comments->count() }}</span>
        </h3>

        <div class="mb-12">
            @auth
                <form action="{{ route('items.comment', $item->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <textarea name="content" rows="3"
                        class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition-all"
                        placeholder="Напишіть свою думку про цей експонат..."></textarea>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-cyan-600 hover:bg-cyan-700 text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-lg shadow-cyan-600/20">
                            Відправити
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl p-8 text-center">
                    <p class="text-gray-500">
                        Тільки зареєстровані користувачі можуть залишати коментарі.
                        <a href="{{ route('login') }}" class="text-cyan-600 font-bold hover:underline">Увійти</a>
                    </p>
                </div>
            @endauth
        </div>

        <div class="space-y-6">
            @forelse($item->comments as $comment)
                <div class="flex gap-4 p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative group/comment">
                    <div class="shrink-0">
                        <img src="{{ $comment->user->avatar_url }}" class="w-12 h-12 rounded-full border-2 border-cyan-500 object-cover shadow-sm">
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-bold text-gray-900">{{ $comment->user->name }}</h4>
                            <div class="flex items-center gap-4">
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-tighter">
                                    {{ $comment->created_at->format('d.m.Y H:i') }}
                                </span>
                                @if(auth()->check() && (auth()->user()->is_admin >= 1 || auth()->id() === $comment->user_id))
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative overflow-hidden p-1 text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $comment->content }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-gray-400 italic">Тут ще немає жодного коментаря. Будьте першим!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection