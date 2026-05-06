@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Изменение статуса</h1>
            <form method="POST" action="{{ route('task_statuses.update', $status->id) }}" class="p-6">
                @csrf
                @method('PATCH')
                
                <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ $status->name }}"
                           class="w-full px-4 py-2 mb-6 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('task_statuses.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        Изменить статус
                    </button>
                </div>
            </form>
        </div>
@endsection