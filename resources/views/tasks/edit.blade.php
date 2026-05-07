@extends('layouts.app')

@section('title', "Редактировать задачу")

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-bold mb-6">{{ "Редактировать задачу" }}</h2>
            
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ "Название задачи" }} <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">{{ "Описание задачи" }}</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $task->description) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">{{ "Статус" }} <span class="text-red-500">*</span></label>
                    <select name="status_id" id="status_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">{{ "Выберите статус задачи" }}</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="assigned_to_id" class="block text-sm font-medium text-gray-700 mb-2">{{ "Исполнитель" }}</label>
                    <select name="assigned_to_id" id="assigned_to_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ "Выберите исполнителя" }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="labels" class="block text-sm font-medium text-gray-700 mb-2">{{ "Метки" }}</label>
                    <select name="labels[]" id="labels" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($labels as $label)
                            <option value="{{ $label->id }}" {{ in_array($label->id, old('labels', $task->labels->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $label->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">{{ "Чтобы выделить несколько меток, удерживайте Ctrl (Windows) или Command (Mac) и выберите нужные метки" }}</p>
                </div>
                
                <div class="flex justify-end space-x-2">
                        <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">{{ "Отмена" }}</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">{{ "Обновить" }}</button>             
                </div>
            </form>
        </div>
    </div>
</div>
@endsection