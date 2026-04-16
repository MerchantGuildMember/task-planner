<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page header --}}
            <div class="mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Admin Panel</h1>
                    <p class="text-white/40 text-sm mt-0.5">Manage users, seed test data, monitor the app</p>
                </div>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium"
                    style="background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.3); color: #6ee7b7;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium"
                    style="background: rgba(248,113,113,0.15); border: 1px solid rgba(248,113,113,0.3); color: #fca5a5;">
                    ⚠ {{ session('error') }}
                </div>
            @endif

            {{-- Stats row --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
                @php
                    $statCards = [
                        ['label' => 'Total Users',  'value' => $stats['total_users'],  'color' => '#a5b4fc'],
                        ['label' => 'Real Users',   'value' => $stats['real_users'],   'color' => '#6ee7b7'],
                        ['label' => 'Fake Users',   'value' => $stats['fake_users'],   'color' => '#fbbf24'],
                        ['label' => 'Admins',       'value' => $stats['admin_users'],  'color' => '#c084fc'],
                        ['label' => 'Total Tasks',  'value' => $stats['total_tasks'],  'color' => '#93c5fd'],
                        ['label' => 'Fake Tasks',   'value' => $stats['fake_tasks'],   'color' => '#f9a8d4'],
                    ];
                @endphp
                @foreach($statCards as $card)
                    <div class="rounded-xl px-4 py-3 text-center"
                        style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="text-2xl font-bold" style="color: {{ $card['color'] }};">{{ $card['value'] }}</div>
                        <div class="text-xs mt-0.5" style="color: rgba(255,255,255,0.4);">{{ $card['label'] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- Left column: tools --}}
                <div class="flex-shrink-0 w-full lg:w-80 space-y-4">

                    {{-- Seed fake users --}}
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="px-5 py-4" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"/>
                                </svg>
                                <h2 class="text-sm font-bold text-white">Generate Fake Users</h2>
                            </div>
                            <p class="text-indigo-200 text-xs mt-1">Creates seeded users with realistic tasks. Passwords are all <code class="bg-white/20 px-1 rounded">password</code>.</p>
                        </div>

                        <form method="POST" action="{{ route('admin.seed') }}" class="p-5 space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                                    Number of users
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="range" name="user_count" id="user_count"
                                        min="1" max="20" value="{{ old('user_count', 3) }}"
                                        oninput="document.getElementById('user_count_val').textContent = this.value"
                                        class="flex-1" style="accent-color: #6366f1;">
                                    <span id="user_count_val" class="w-6 text-center text-sm font-semibold text-gray-700">{{ old('user_count', 3) }}</span>
                                </div>
                                @error('user_count')<p class="text-xs mt-1 text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                                    Tasks per user
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="range" name="tasks_per_user" id="tasks_per_user"
                                        min="1" max="10" value="{{ old('tasks_per_user', 4) }}"
                                        oninput="document.getElementById('tasks_per_user_val').textContent = this.value"
                                        class="flex-1" style="accent-color: #6366f1;">
                                    <span id="tasks_per_user_val" class="w-6 text-center text-sm font-semibold text-gray-700">{{ old('tasks_per_user', 4) }}</span>
                                </div>
                                @error('tasks_per_user')<p class="text-xs mt-1 text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                                    Subtasks per task
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="range" name="subtasks_per_task" id="subtasks_per_task"
                                        min="0" max="5" value="{{ old('subtasks_per_task', 2) }}"
                                        oninput="document.getElementById('subtasks_per_task_val').textContent = this.value"
                                        class="flex-1" style="accent-color: #6366f1;">
                                    <span id="subtasks_per_task_val" class="w-6 text-center text-sm font-semibold text-gray-700">{{ old('subtasks_per_task', 2) }}</span>
                                </div>
                                @error('subtasks_per_task')<p class="text-xs mt-1 text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                                    % completed
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="range" name="percent_completed" id="percent_completed"
                                        min="0" max="100" value="{{ old('percent_completed', 40) }}"
                                        oninput="document.getElementById('percent_completed_val').textContent = this.value + '%'"
                                        class="flex-1" style="accent-color: #6366f1;">
                                    <span id="percent_completed_val" class="w-8 text-center text-sm font-semibold text-gray-700">{{ old('percent_completed', 40) }}%</span>
                                </div>
                                @error('percent_completed')<p class="text-xs mt-1 text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit"
                                class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90 hover:shadow-lg active:scale-95"
                                style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                Generate Users
                            </button>
                        </form>
                    </div>

                    {{-- Clear fake users --}}
                    @if($stats['fake_users'] > 0)
                        <div class="bg-white rounded-2xl shadow-xl p-5">
                            <h2 class="text-sm font-bold text-gray-700 mb-1">Clear Fake Data</h2>
                            <p class="text-xs text-gray-400 mb-4">
                                Permanently removes all {{ $stats['fake_users'] }} fake user(s)
                                and their {{ $stats['fake_tasks'] }} task(s). This cannot be undone.
                            </p>
                            <form method="POST" action="{{ route('admin.clearFake') }}"
                                onsubmit="return confirm('Delete all {{ $stats['fake_users'] }} fake users and their {{ $stats['fake_tasks'] }} tasks?')">
                                @csrf
                                <button type="submit"
                                    class="w-full py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-md active:scale-95"
                                    style="border: 1.5px solid #fca5a5; color: #ef4444;"
                                    onmouseover="this.style.background='#fef2f2';"
                                    onmouseout="this.style.background='';">
                                    🗑 Remove All Fake Users
                                </button>
                            </form>
                        </div>
                    @endif

                </div>

                {{-- Right column: user table --}}
                <div class="flex-1">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="px-6 py-4" style="border-bottom: 1px solid #f3f4f6;">
                            <h2 class="text-sm font-bold text-gray-700">All Users</h2>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $stats['total_users'] }} registered accounts</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">User</th>
                                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tasks</th>
                                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Joined</th>
                                        <th class="px-5 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr style="border-bottom: 1px solid #f9fafb;"
                                            onmouseover="this.style.background='#fafafa';"
                                            onmouseout="this.style.background='';">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                                        style="background: linear-gradient(135deg, {{ $user->is_fake ? '#9ca3af, #6b7280' : '#6366f1, #8b5cf6' }});">
                                                        {{ strtoupper(substr($user->email, 0, 1)) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="text-sm font-medium text-gray-800 truncate">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-400 truncate">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col gap-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold w-fit"
                                                        style="{{ $user->role === 'admin' ? 'background:#ede9fe; color:#7c3aed;' : 'background:#f3f4f6; color:#6b7280;' }}">
                                                        {{ $user->role === 'admin' ? '👑 Admin' : 'User' }}
                                                    </span>
                                                    @if($user->is_fake)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold w-fit"
                                                            style="background:#fef3c7; color:#d97706;">
                                                            🤖 Fake
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-sm text-gray-600">
                                                {{ $user->tasks_count }}
                                            </td>
                                            <td class="px-5 py-3 text-xs text-gray-400">
                                                {{ $user->created_at->format('d/m/y') }}
                                            </td>
                                            <td class="px-5 py-3 text-right">
                                                @if($user->id !== auth()->id())
                                                    <form method="POST"
                                                        action="{{ route('admin.toggleRole', $user) }}"
                                                        onsubmit="return confirm('Toggle role for {{ $user->email }}?')"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-xs font-medium px-3 py-1 rounded-lg transition-colors duration-150"
                                                            style="color: {{ $user->role === 'admin' ? '#ef4444' : '#6366f1' }}; border: 1px solid {{ $user->role === 'admin' ? '#fca5a5' : '#c7d2fe' }};"
                                                            onmouseover="this.style.background='{{ $user->role === 'admin' ? '#fef2f2' : '#eef2ff' }}';"
                                                            onmouseout="this.style.background='';">
                                                            {{ $user->role === 'admin' ? 'Demote' : 'Make Admin' }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-gray-300">You</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($users->hasPages())
                            <div class="px-5 py-4" style="border-top: 1px solid #f3f4f6;">
                                {{ $users->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
