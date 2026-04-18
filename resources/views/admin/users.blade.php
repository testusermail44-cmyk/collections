@extends('layouts.app')
@section('title', 'Керування користувачами')
@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 shadow shadow-gray-600/60 rounded-xl border border-gray-100">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold uppercase tracking-tighter">
                Управління доступом
            </h2>
        </div>
        <span class="bg-cyan-600 text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border border-cyan-500/30">
            Всього: {{ $users->count() }}
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-y-3">
            <thead>
                <tr class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <th class="px-6 py-3">Користувач</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3 text-center">Роль</th>
                    <th class="px-6 py-3 text-right">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="bg-gray-50/50 transition-all duration-300 rounded-2xl group">
                    <td class="px-6 py-4 rounded-l-2xl border-y border-transparent">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="{{ $user->avatar_url }}" class="w-12 h-12 rounded-full border-2 border-cyan-500 shadow-md object-cover">
                                @if($user->is_admin > 0)
                                    <div class="absolute -bottom-1 -right-1 bg-cyan-500 text-white p-1 rounded-full shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M2.166 4.9L9.03 9.069a2.492 2.492 0 003.939 1.428l4.865-2.93a1 1 0 10-1.034-1.713l-4.865 2.93a.492.492 0 01-.776-.282V4.5a1 1 0 00-2 0v1.071L3.2 2.034a1 1 0 00-1.034 1.713l.001-.001L2.166 4.9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="font-black text-gray-800 text-lg">{{ $user->name }} {{ $user->lastname }}</div>
                                <div class="text-[10px] font-bold text-cyan-600/50 uppercase tracking-tighter">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-semibold border-y border-transparent">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-center border-y border-transparent">
                        @if($user->is_admin == 1)
                            <span class="bg-cyan-500 text-white px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest shadow-lg shadow-cyan-200">
                                Адміністратор
                            </span>
                        @else
                            <span class="text-gray-500 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest">
                                Колекціонер
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right rounded-r-2xl border-y border-transparent">
                        @if($user->is_admin != 2 && $user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-primary relative">
                                    <span class="absolute inset-0 w-full h-full transition duration-300 ease-out opacity-0 bg-current group-hover/btn:opacity-10"></span>
                                    @if($user->is_admin == 1)
                                        <span class="flex items-center gap-2">Понизити</span>
                                    @else
                                        <span class="flex items-center gap-2">Надати доступ адміна</span>
                                    @endif
                                </button>
                            </form>
                        @else
                            <div class="flex justify-end pr-4">
                                <div class="w-2 h-2 rounded-full bg-gray-300 animate-pulse"></div>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection