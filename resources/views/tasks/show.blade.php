@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-start mb-6">
            <div class="space-x-2">
                <a href="{{ route('tasks.edit', $task) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                    {{ "Редактировать задачу" }}
                </a>
                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    {{ ('Назад') }}
                </a>
            </div>
        </div>
        
        <div class="space-y-6">
            <div>
                <p class="text-lg font-semibold mb-2">{{ "Просмотр задачи: " . $task->name }}</p>
                <span class="text-gray-700">Описание: {{ $task->description ?? ('Нет описания') }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">{{ "Статус" }}</h3>
                    <p class="mt-1"><span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $task->status->name }}</span></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">{{ "Создатель" }}</h3>
                    <p class="mt-1 text-gray-900">{{ $task->createdBy->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">{{ "Исполнитель" }}</h3>
                    <p class="mt-1 text-gray-900">{{ $task->assignedTo?->name ?? ('Нет исполнителя') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">{{ "Метки" }}</h3>
                    <div class="mt-1 flex flex-wrap gap-1">
                        @forelse($task->labels as $label)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $label->color }}-100 text-{{ $label->color }}-800">{{ $label->name }}</span>
                        @empty
                            <p class="text-gray-500">{{ "Нет меток" }}</p>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">{{ "Дата создания" }}</h3>
                    <p class="mt-1 text-gray-900">{{ $task->created_at->format('d.m.Y H:i') }}</p>
                    <p class="mt-1 text-gray-900">ID: {{ $task->id }}</p>
                </div>
            </div>
        </div>
        
        @can('delete', $task)
            <div class="mt-6 pt-4 border-t border-gray-200">
                <form action="{{ route('tasks.destroy', $task) }}" 
                    method="POST" 
                    onsubmit="return confirm('Вы уверены, что хотите удалить эту задачу?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">{{ "Удалить задачу" }}</button>
                </form>
            </div>
        @endcan
    </div>
</div>
@endsection