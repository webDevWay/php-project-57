@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Менеджер задач</h1>
                <p class="text-gray-600 mt-1">Создание новой задачи</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 transition">
                ← Назад к списку
            </a>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('tasks.store') }}" class="p-6">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Имя <span class="text-red-500">*</span>
                        </label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror" placeholder="Введите название задачи" value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Описание
                        </label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Подробное описание задачи...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Статус
                        </label>
                        <select name="status_id" id="status_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none    focus:ring-2 focus:ring-indigo-500">
                        <option value="">Выберите статус задачи</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" 
                                class="px-2 py-1 rounded bg-{{ $status->color }}-100 text-{{ $status->color }}-800" 
                                {{ old('status_id') == $status->id ? 'selected' : '' }}> 
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="executor" class="block text-sm font-medium text-gray-700 mb-2">
                            Исполнитель
                        </label>
                        <select name="assigned_to_id" id="assigned_to_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Выберите исполнителя</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('assigned_to_id') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="labels" class="block text-sm font-medium text-gray-700 mb-2">Метки (нажмите сюда для выбора меток)
                            <p class="mt-1 text-sm text-gray-400">Чтобы выделить несколько меток, удерживайте Ctrl (Windows) или Command (Mac) и выберите нужные метки</p>
                        </label>
                            <select name="labels[]" id="labels" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @foreach($labels as $label)
                                    <option value="{{ $label->id }}" class="px-2 py-1 rounded bg-{{ $label->color }}-100 text-{{ $label->color }}-800" 
                                        @selected(in_array($label->id, old('labels', [])))> {{ $label->name }}  </option>
                                @endforeach
                            </select>
                            @error('labels') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('tasks.index') }}" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Отмена
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            Создать
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection