<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\QueryBuilders\TaskQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = TaskQueryBuilder::build()->paginate(15);
        $statuses = TaskStatus::all();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'statuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.create', compact('statuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ], $messages);

        $task = Auth::user()->createdTasks()->make($validated);
        $task->save();

        if (isset($validated['labels']) && $validated['labels'] !== []) {
            $task->labels()->sync($validated['labels']);
        }

        return redirect()->route('tasks.index')
            ->with('success', ('Задача успешно создана'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, User $user)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

        $task->update($validated);

        if (isset($validated['labels'])) {
            $task->labels->sync($validated['labels']);
        } else {
            $task->labels->sync([]);
        }

        return redirect()->route('tasks.index')
            ->with('success', ('Задача успешно изменена'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Task $task)
    {
        if ($task->createdBy->id !== Auth::id()) {
            return redirect()->route('tasks.index')
                ->with('error', ('Невозможно удалить чужую задачу'));
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', ('Задача успешно удалена'));
    }
}
