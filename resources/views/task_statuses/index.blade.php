@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Статусы</h1>
    @auth
        <div class="mb-6">        
            <a href="{{ route('task_statuses.create') }}"class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-md transition">
                Создать статус
            </a>
        </div>
    @endauth
    @if($statuses->count())
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">            
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата создания</th>
                        @auth
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        @endauth
                    </tr>
                </thead>
            @foreach ($statuses as $status)
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> {{ $status->id }} </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $status->color }}-100 text-{{ $status->color }}-800"> {{ $status->name }} </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"> {{ $status->created_at?->format('d.m.Y') }} </td>
                        @auth
                            <td>
                            <form method="POST" action="{{ route('task_statuses.destroy', $status->id) }}" onsubmit="return confirm('{{ ('Подтвердите удаление') }}')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs px-2 py-1 rounded-full bg-red-200 text-red-900"> Удалить</button> |
                                <a class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800" href="{{ route('task_statuses.edit', $status->id) }}"> Изменить </a>
                            </form>
                        </td>
                        @endauth
                    </tr>
                </tbody>
            @endforeach  
            </table>
        </div>
        </div>
        <div class="mt-4">{{ $statuses->links() }}</div>
    @endif
@endsection