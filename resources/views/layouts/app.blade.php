<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Task Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased bg-gray-100">
        <nav class="bg-gray-800 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-xl font-semibold">Менеджер задач</a>
                    <div class="flex space-x-4">
                        <a href="{{ route('tasks.index') }}" class="hover:text-gray-300">Задачи</a>
                        <a href="{{ route('task_statuses.index') }}" class="hover:text-gray-300">Статусы</a>
                        <a href="{{ route('labels.index') }}" class="hover:text-gray-300">Метки</a>
                    </div>
                </div>
                <div>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-gray-300">Выход</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 hover:text-gray-300 mr-2 py-2 px-6 rounded-md transition">Вход</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 hover:text-gray-300 py-2 px-6 rounded-md transition">Регистрация</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="container mx-auto px-4 py-4">
            @if(session('success'))
                <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')           

        </main>
    </body>
</html>
