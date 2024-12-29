<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use App\Http\Resources\TaskListResource;
use App\Models\User;

class TaskListController extends Controller
{
    public function index()
    {
        // Get the user's task lists
        $ownTaskLists = auth()->user()->taskLists()->with('tasks')->get();

        // Get the task lists shared with the user
        $sharedTaskLists = auth()->user()->sharedTaskLists()->with('tasks')->get();

        // Merge the collections
        $allTaskLists = $ownTaskLists->merge($sharedTaskLists);

        return TaskListResource::collection($allTaskLists);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $taskList = auth()->user()->taskLists()->create($validatedData);

        return new TaskListResource($taskList->load('tasks'));
    }

    public function show(TaskList $taskList)
    {
        return new TaskListResource($taskList->load('tasks'));
    }

    public function update(Request $request, TaskList $taskList)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $taskList->update($validatedData);

        return new TaskListResource($taskList->load('tasks'));
    }

    public function destroy(TaskList $taskList)
    {
        $taskList->delete();

        return response()->json(null, 204);
    }

    public function share(Request $request, TaskList $taskList)
    {
        \Log::info('Share method reached', [
            'task_list_id' => $taskList->id,
            'request' => $request->all()
        ]);

        // Check if the username exists in the database
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the task list is already shared with this user
        if (!$taskList->sharedUsers()->where('user_id', $user->id)->exists()) {
            $taskList->sharedUsers()->attach($user->id, ['permission' => $request->permission]);
        }

        return response()->json(['message' => 'Task list shared successfully'], 200);
    }

    public function sharedLists()
    {
        $sharedLists = auth()->user()->sharedTaskLists()->with('tasks')->get();
        return TaskListResource::collection($sharedLists);
    }
}
