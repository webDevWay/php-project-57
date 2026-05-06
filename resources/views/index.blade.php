@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            Привет от Хекслета!
        </h1>
        <p class="text-gray-600 text-lg mb-8">
            Это простой менеджер задач на Laravel
        </p>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition">
            Нажми меня
        </button>
    </div>
</div>
@endsection