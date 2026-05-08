<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::paginate(15);

        return view('task_statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }

        return view('task_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует',
        ];

        $data = $request->validate([
            'name' => 'required|min:3|max:100|unique:task_statuses',
            'color' => 'string',
        ], $messages);

        TaskStatus::create($data);

        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно создан');
    }

    public function show(TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }

        return view('task_statuses.edit', ['status' => $taskStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }

        $data = $request->validate([
            'name' => 'required|min:3|max:100|unique:task_statuses',
        ]);

        $taskStatus->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно изменён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }

        if (! $taskStatus->canBeDeleted()) {
            return redirect()->route('task_statuses.index')
                ->with('error', 'Не удалось удалить статус');
        }

        $taskStatus->delete();

        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно удалён');
    }
}
