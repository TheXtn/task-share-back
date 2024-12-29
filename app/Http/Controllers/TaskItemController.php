<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskItemController extends Controller
{
    public function __construct()
    {
    
    }

    public function index(TaskList $taskList)
    {
        
        return TaskResource::collection($taskList->tasks);
    }

    public function store(Request $request, TaskList $taskList)
    {
    ;

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $taskList->tasks()->create($validatedData);

        return new TaskResource($task);
    }

    public function show(TaskList $taskList, Task $task)
    {
    
        return new TaskResource($task);
    }

    public function update(Request $request, TaskList $taskList, Task $task)
    {
        
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        $task->update($validatedData);

        return new TaskResource($task);
    }

    public function destroy(TaskList $taskList, Task $task)
    {


        $task->delete();

        return response()->json(null, 204);
    }
}

