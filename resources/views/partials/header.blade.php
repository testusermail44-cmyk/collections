<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&display=swap" rel="stylesheet">
<header class="bg-white shadow-md shadow-gray-400/30">
    <nav class="container mx-auto px-4 md:px-2 py-3 flex flex-row justify-between">
        <a href="/" class="flex flex-row items-end gap-0">
            <img class="w-10 h-10 md:w-12 md:h-12 object-contain" src="{{asset('images/logo.png')}}" />
            <span class="hidden md:flex lg:flex text-base md:text-2xl py-0.5 font-black font-['Orbitron'] uppercase tracking-tighter
                     bg-gradient-to-b from-cyan-300 via-cyan-500 to-blue-600 
                     bg-clip-text text-transparent
                     drop-shadow-[0_0_8px_rgba(34,211,238,0.8)] skew-x-[-15deg]">
                ollections
            </span>
        </a>
        <div class="flex flex-row gap-1">
            @auth
                <div class="flex flex-row gap-5 items-center">
                    <a href="/collections/collections" class="btn-primary">Переглянути колекції</a>
                    <a href="/collections/create" class="btn-primary">Додати колекцію</a>
                    <div class="relative group">
                        <div class="flex flex-row gap-2 items-center cursor-pointer py-2">
                            <img src="{{ auth()->user()->avatar_url }}"
                                class="w-10 h-10 rounded-full border-2 border-cyan-500 shadow-[0_0_10px_rgba(34,211,238,0.3)] object-cover">
                            <div
                                class="flex flex-row text-lg font-medium text-gray-800 group-hover:text-cyan-400 transition-colors">
                                {{ auth()->user()->name . ' ' . auth()->user()->lastname }}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 ml-1 mt-1 transition-transform group-hover:rotate-180" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="absolute right-0 w-48 mt-0 origin-top-right invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50">
                            <div
                                class="py-1 bg-slate-900 border border-cyan-500/30 rounded-lg shadow-[0_10px_25px_rgba(0,0,0,0.5)] backdrop-blur-xl">
                                @if(auth()->user()->is_admin == 1 || auth()->user()->is_admin == 2)
                                    <div
                                        class="px-4 py-1 text-[10px] font-black text-cyan-500 uppercase tracking-widest opacity-50">
                                        Адмін-панель</div>
                                    <a href="/admin/categories"
                                        class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-cyan-500/10 hover:text-cyan-400 transition-colors">
                                        <span class="mr-2">🏷️</span> Категорії
                                    </a>
                                    <a href="/admin/users"
                                        class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-cyan-500/10 hover:text-cyan-400 transition-colors">
                                        <span class="mr-2">👥</span> Користувачі
                                    </a>
                                    <div class="border-t border-cyan-500/20 my-1"></div>
                                @endif
                                <a href="/collections/collections/my"
                                    class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-cyan-500/10 hover:text-cyan-400 transition-colors">
                                    <span class="mr-2">📂</span> Мої колекції
                                </a>
                                <a href="/user/settings"
                                    class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-cyan-500/10 hover:text-cyan-400 transition-colors">
                                    <span class="mr-2">⚙️</span> Налаштування
                                </a>
                                <div class="border-t border-cyan-500/20 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors">
                                        <span class="mr-2">🚪</span> Вихід
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
            @guest
                <a href="collection/collections" class="btn-primary">Переглянути колекції</a>
                <a href="auth/login" class="btn-primary">Увійти</a>
            @endguest
        </div>
    </nav>
</header>