<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $tasks = Task::where('user_id', $user->id)
            ->get()
            ->toArray();

        return response()->json($tasks, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in progress,completed',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => auth()->id(),
            'team_id' => $request->team_id,
        ]);

        return response()->json($task, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            return response()->json($task, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in progress,completed',
            'user_id' => 'required|exists:users,id',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        try {
            $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => $request->user_id,
                'team_id' => $request->team_id,
            ]);

            return response()->json($task, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found or does not belong to you'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$task) {
            return response()->json(['error' => 'Task not found or you do not have permission to delete it.'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.'], 200);
    }
}
