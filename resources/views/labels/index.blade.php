@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Заголовок -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Метки</h1>
            @auth
                <a href="{{ route('labels.create') }}"class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-md transition">
                Создать метку
            </a>
            @endauth
        </div>
    @if($labels->count())   
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4  py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4  py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                        <th class="px-4  py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Описание</th>
                        <th class="px-4  py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата создания</th>
                        @auth
                            <th class="px-4  py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        @endauth
                    </tr>
                </thead>
            @foreach ($labels as $label)
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> {{ $label->id }} </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $label->color }}-100 text-{{ $label->color }}-900"> {{ $label->name }} </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600"> {{ $label->description }} </td>
                        <td class="px-4 py-4  text-sm text-gray-500"> {{ $label->created_at?->format('d.m.Y') }} </td>
                        @auth
                            <td>
                                <a class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800" href="{{ route('labels.edit', $label->id) }}">Изменить</a> | 
                                <a href="{{ route('labels.destroy', $label->id) }}" 
                                    onclick="event.preventDefault(); if(confirm('Подтвердите удаление')) 
                                    document.getElementById('delete-form-{{ $label->id }}').submit();"
                                    class="text-xs px-2 py-1 rounded-full bg-red-200 text-red-700 hover:bg-red-300 transition">
                                     Удалить
                                 </a>
                                 
                                 <form id="delete-form-{{ $label->id }}" onsubmit="return confirm('{{ ('Подтвердите удаление') }}')"
                                       action="{{ route('labels.destroy', $label->id) }}" 
                                       method="POST" 
                                       style="display: none;">
                                     @csrf 
                                     @method('DELETE')
                                 </form>
                            </td>
                        @endauth
                    </tr>
                </tbody>
            @endforeach
            </table>
        </div>        
    </div>  
    <div class="mt-4 px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">{{ $labels->links() }}</div>
    @endif
@endsection