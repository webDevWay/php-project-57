@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto">
        <div class="">
            <h1 class="text-2xl font-bold text-gray-800">Задачи</h1>
            <p class="text-gray-600 mt-1">Управление задачами проекта</p>
        </div>        
        @auth
            <div class="flex space-x-3 mt-4">
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm  font-medium rounded-lg hover:bg-blue-700 transition shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Создать задачу</span>
                </a>
            </div>
        @endauth
            <form method="GET" action="{{ route('tasks.index') }}" class="p-4 bg-gray-100 rounded-lg">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-4 items-end">
                    <div>
                        <select name="filter[status_id]" 
                                id="filter[status_id]" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none bg-white appearance-none"">
                            <option value="">{{ ('Статус') }}</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" @selected(request('filter.status_id') == $status->id)>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="filter[created_by_id]"
                                id="filter[created_by_id]" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none">
                            <option value="">{{'Автор'}}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(request('filter.created_by_id') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="filter[assigned_to_id]" 
                                placeholder="Поиск по исполнителю..."
                                class="w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Исполнитель</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(request('filter.assigned_to_id') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" 
                            class="py-3 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        <span>Применить</span>
                    </button>
                </div>
            </form>
            </div>
        @if ($tasks->count())
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Автор</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Исполнитель</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата создания</th>
                            @auth
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                            @endauth
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-200">
                        @foreach($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <a href="{{ route('tasks.show', $task) }}" class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $task->status->color }}-100 text-{{ $task->status->color }}-800">{{ $task->status->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-indigo-900 px-2 py-1 text-xs font-semibold rounded-full">{{ $task->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">{{ $task->creator->name }}</span>
                                </div>
                            </td>
                            <?php //dump($task)?>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $task->assignee?->name ?? ('Нет исполнителя') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $task->created_at?->format('d.m.Y') }}</td>
                            @auth
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900">{{ ('Изменить') }}</a>
                            @can('delete', $task)
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('{{  ('Подтверждате удаление?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"><a>{{ ('Удалить') }}</a></button>
                                </form>
                                </td>
                            @endcan
                                
                            @endauth
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
            <div class="mt-4">{{ $tasks->links() }}</div>
        @else
            <p class="text-gray-600 mt-8 pt-8">Задачи не найдены. 
                @if (!auth()->check())
                    Чтобы создать задачу, нужно быть <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900">Зарегистрированным пользователем</a>
                @endif
            </p>
        @endif
@endsection