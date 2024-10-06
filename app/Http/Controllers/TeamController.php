<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $teams = auth()->user()->teams;

        if ($teams->isEmpty()) {
            return response()->json(['message' => 'Du you not have commands!'], 404);
        }

        return response()->json($teams, 200);
    }

    /**
     * Add a user to a specified team.
     *
     * This method validates the request to ensure the user ID exists
     * before attaching the user to the team.
     *
     * @param \Illuminate\Http\Request $request The request instance containing the user ID.
     * @param int $teamId The ID of the team to which the user will be added.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the team does not exist.
     */
    public function addUser(Request $request, $teamId)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $team = Team::findOrFail($teamId);

        $team->users()->attach($request->user_id);

        return response()->json(['message' => 'User added.'], 200);
    }

    /**
     * Remove a user from a specified team.
     *
     * This method checks if the user is a member of the team before detaching them.
     *
     * @param int $teamId The ID of the team from which the user will be removed.
     * @param int $userId The ID of the user to be removed from the team.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the team or user does not exist.
     */
    public function removeUser($teamId, $userId)
    {
        $team = Team::findOrFail($teamId);
        $user = User::findOrFail($userId);

        if ($team->users()->where('users.id', $userId)->exists()) {
            $team->users()->detach($userId);
            return response()->json(['message' => 'User removed from the team successfully.'], 200);
        }

        return response()->json(['message' => 'User is not a member of this team.'], 404);
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
            'name' => 'required|string|max:255|unique:teams,name',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $team = Team::create([
            'name' => $request->name,
        ]);

        return response()->json($team, 200);
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
