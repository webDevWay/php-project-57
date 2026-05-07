@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto">
        <!-- Заголовок -->
        <div class="mb-3">
            <h1 class="text-2xl font-bold text-gray-800">Создать статус</h1>
            <p class="text-gray-600 mt-1">Добавьте новый статус для задач</p>
        </div>

        <!-- Карточка формы -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('task_statuses.store') }}" class="p-6">
                @csrf
                
                <!-- Поле Имя -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Имя <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value=""
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none"
                           placeholder="Например: В работе, Завершена, Отложена"
                           >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Минимум 3 символа, максимум 50</p>
                </div>

                <div class="mb-6">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Цвет статуса
                    </label>
                    
                    <div class="flex items-center space-x-4">
                        <select name="color" 
                                id="color" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none bg-white font-medium">
                            <option value="gray" {{ old('color') == 'gray' ? 'selected' : '' }}>⬜ Серый</option>
                            <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>🟥 Красный</option>
                            <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>🟦 Синий</option>
                            <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>🟩 Зелёный</option>
                            <option value="yellow" {{ old('color') == 'yellow' ? 'selected' : '' }}>🟨 Жёлтый</option>
                            <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>🟪 Фиолетовый</option>
                            <option value="indigo" {{ old('color') == 'indigo' ? 'selected' : '' }}>🟦 Индиго</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('task_statuses.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        Создать
                    </button>
                </div>
            </form>
        </div>

        <!-- Примеры статусов -->
        <div class="mt-4 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Примеры статусов:</h3>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gray-100 text-gray-800">Новая</span>
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">В работе</span>
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-blue-100 text-blue-800">На проверке</span>
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-green-100 text-green-800">Завершена</span>
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-red-100 text-red-800">Отложена</span>
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-purple-100 text-purple-800">Архив</span>
            </div>
        </div>
    </div>
@endsection