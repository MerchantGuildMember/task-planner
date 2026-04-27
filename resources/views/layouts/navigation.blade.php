<nav style="background: rgba(15,23,42,0.80); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(99,102,241,0.25);" class="sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">

        {{-- Main row --}}
        <div class="flex items-center justify-between gap-4">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 text-white font-bold text-base tracking-tight flex-shrink-0">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                    style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="hidden sm:block">Task Planner</span>
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('tasks.index') }}"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('tasks.index') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/10' }}"
                    style="{{ request()->routeIs('tasks.index') ? 'background: rgba(99,102,241,0.3);' : '' }}">
                    My Tasks
                </a>
                <a href="{{ route('tasks.create') }}"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('tasks.create') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/10' }}"
                    style="{{ request()->routeIs('tasks.create') ? 'background: rgba(99,102,241,0.3);' : '' }}">
                    + New Task
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.index') }}"
                            class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-150
                                {{ request()->routeIs('admin.*') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/10' }}"
                            style="{{ request()->routeIs('admin.*') ? 'background: rgba(139,92,246,0.35);' : '' }}">
                            ⚙ Admin
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="text-white/30 text-sm hidden lg:block truncate max-w-[160px]">{{ Auth::user()->email }}</span>

                <a href="{{ route('profile.edit') }}"
                    class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-bold hover:opacity-80 transition-opacity flex-shrink-0"
                    style="background: linear-gradient(135deg, #6366f1, #a855f7);"
                    title="Profile">
                    {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                </a>

                {{-- Desktop logout --}}
                <form method="POST" action="{{ route('logout') }}" class="hidden md:flex">
                    @csrf
                    <button type="submit"
                        class="text-sm text-white/40 hover:text-red-400 font-medium transition-colors duration-150">
                        Log out
                    </button>
                </form>

                {{-- Mobile hamburger --}}
                <button type="button" id="mobile-menu-btn"
                    class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg transition-colors duration-150"
                    style="color: rgba(255,255,255,0.5);"
                    aria-label="Toggle menu">
                    <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile dropdown menu --}}
        <div id="mobile-menu" class="hidden md:hidden pt-3 pb-1" style="border-top: 1px solid rgba(255,255,255,0.08); margin-top: 12px;">
            <div class="flex flex-col gap-1">
                <a href="{{ route('tasks.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('tasks.index') ? 'text-white' : 'text-white/60' }}"
                    style="{{ request()->routeIs('tasks.index') ? 'background: rgba(99,102,241,0.25);' : '' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    My Tasks
                </a>
                <a href="{{ route('tasks.create') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('tasks.create') ? 'text-white' : 'text-white/60' }}"
                    style="{{ request()->routeIs('tasks.create') ? 'background: rgba(99,102,241,0.25);' : '' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Task
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors duration-150
                                {{ request()->routeIs('admin.*') ? 'text-white' : 'text-white/60' }}"
                            style="{{ request()->routeIs('admin.*') ? 'background: rgba(139,92,246,0.25);' : '' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Admin
                        </a>
                    @endif
                @endauth

                <div class="mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.08);">
                    <p class="text-white/30 text-xs px-3 mb-1 truncate">{{ Auth::user()->email }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium text-left transition-colors duration-150 text-white/60 hover:text-red-400">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</nav>

<script>
    const mobileBtn  = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburger  = document.getElementById('hamburger-icon');
    const closeIcon  = document.getElementById('close-icon');

    mobileBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        hamburger.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
</script>
