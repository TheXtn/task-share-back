<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index(TaskList $taskList)
    {
        $tasks = $taskList->tasks;
        return TaskResource::collection($tasks);
    }

    public function store(Request $request, TaskList $taskList)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $taskList->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
        ]);

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        $task->update($request->all());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
    public function share(Request $request, TaskList $taskList)
    {
        \Log::info('Share method reached', ['task_list_id' => $taskList->id, 'request' => $request->all()]);
        
        return response()->json(['message' => 'Task list shared successfully.']);
    }

    
}