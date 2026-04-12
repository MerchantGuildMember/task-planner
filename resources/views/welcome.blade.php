<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Planner - Stay Focused</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    {{-- Navigation --}}
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <span class="text-xl font-bold text-indigo-600">Task Planner</span>
        <div class="flex gap-4">
            @auth
                <a href="{{ route('tasks.index') }}"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="px-5 py-2 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 text-sm font-medium">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                        Register
                    </a>
                @endif
            @endauth
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="max-w-4xl mx-auto px-6 py-20 text-center">
        <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
            One task at a time.<br>
            <span class="text-indigo-600">That's the Secret.</span>
        </h1>
        <p class="text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
          In a world full of distractions, Task Planner helps you slow down,
          focus on what matters, and achieve your goals - step by step.
        </p>
        @guest
            <a href="{{ route('register') }}"
                class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-lg font-medium">
                Get Started — It's Free
            </a>
        @endguest
    </section>

    {{-- Focus Tips Section --}}
    <section class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">
                How to actually get things done
            </h2>
            <p class="text-center text-gray-500 mb-12">
                Big tasks feel overwhelming. Here's how to break them down and stay on track.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Tip 1 --}}
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                    <div class="text-3xl mb-3">🎯</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Break big tasks into small steps</h3>
                    <p class="text-gray-600 text-sm">
                        Instead of "Build a website", write "Create homepage layout", "Write about section", "Add contact form".
                        Small steps feel achievable and keep you moving forward.
                    </p>
                </div>

                {{-- Tip 2 --}}
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                    <div class="text-3xl mb-3">⏱️</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Focus on one task at a time</h3>
                    <p class="text-gray-600 text-sm">
                        Multitasking is a myth. Research shows that switching between tasks reduces productivity by up to 40%.
                        Pick one task, finish it, then move on.
                    </p>
                </div>

                {{-- Tip 3 --}}
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                    <div class="text-3xl mb-3">✅</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Mark tasks as completed</h3>
                    <p class="text-gray-600 text-sm">
                        Every time you complete a task, your brain releases dopamine — the "reward chemical".
                        Use this to build momentum throughout your day.
                    </p>
                </div>

                {{-- Tip 4 --}}
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                    <div class="text-3xl mb-3">📅</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Set a due date for everything</h3>
                    <p class="text-gray-600 text-sm">
                        Tasks without deadlines stay on your list forever. Even setting a soft deadline
                        creates a sense of urgency that helps you actually start.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- YouTube Recommendation --}}
    <section class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">
                Want to go deeper?
            </h2>
            <p class="text-center text-gray-500 mb-10">
                Watch this creator for inspiration on focus, minimalism, and building better habits.
            </p>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row items-center gap-6">
                <div class="text-6xl">🎬</div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Matt D'Avella</h3>
                    <p class="text-indigo-600 text-sm font-medium mb-3">Minimalism · Focus · Habits · Productivity</p>
                    <p class="text-gray-600 text-sm mb-4">
                        Matt creates cinematic short films about minimalism, slow living, and building better habits.
                        His videos will make you rethink how you work, what you own, and where you focus your energy.
                        Perfect if you want to do <em>less</em> but achieve <em>more</em>.
                    </p>
                    <a href="https://www.youtube.com/@mattdavella" target="_blank"
                        class="inline-block px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">
                        ▶ Visit Channel on YouTube
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    @guest
    <section class="bg-indigo-600 py-16 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Focus?</h2>
        <p class="text-indigo-200 mb-8 text-lg">Create your free account and start organising your tasks today.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}"
                class="px-8 py-3 bg-white text-indigo-600 rounded-md hover:bg-gray-100 font-semibold">
                Create Account
            </a>
            <a href="{{ route('login') }}"
                class="px-8 py-3 border border-white text-white rounded-md hover:bg-indigo-700 font-semibold">
                Log In
            </a>
        </div>
    </section>
    @endguest

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-sm text-gray-400">
    © {{ date('Y') }} Task Planner · DkIT Server-Side Development CA2 · Maryna Hordiienko & Aleksy Cieslak
</footer>

</body>
</html>