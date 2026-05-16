<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }
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
        return view('task_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует',
        ];

        $validated = $request->validate([
            'name' => 'required|unique:task_statuses|max:255',
            'color' => 'string',
        ], $messages);

        TaskStatus::create($validated);

        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно создан');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', ['status' => $taskStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует',
        ];

        $validated = $request->validate([
            'name' => 'required|max:255|unique:task_statuses',
        ], $messages);

        $taskStatus->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно изменён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->count() === 0) {
            $taskStatus->delete();

            return redirect()->route('task_statuses.index')
                ->with('success', 'Статус успешно удалён');
        } else {
            return redirect()->route('task_statuses.index')
                ->with('error', 'Не удалось удалить статус');
        }
    }
}
