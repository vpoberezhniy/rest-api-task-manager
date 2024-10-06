<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Get the authenticated user.
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Register a new user.
Route::post('/register', function (Request $request) {
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return response()->json($user);
});

// Authenticate a user and issue a token.
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if ($user && password_verify($request->password, $user->password)) {
        return response()->json([
            'token' => $user->createToken('token-name')->plainTextToken,
            'redirect' => route('dashboard') // URL для перенаправлення
        ]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
})->name('login');

// Protected routes that require authentication
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tasks
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{task_id}/edit', [TaskController::class, 'edit']);
    Route::put('/tasks/{task_id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task_id}', [TaskController::class, 'destroy']);

    // Tasks comment
    Route::get('/tasks/{task_id}/comments', [CommentController::class, 'index']);
    Route::post('/tasks/{task_id}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment_id}', [CommentController::class, 'destroy']);

    // Team
//    Route::apiResource('teams', TeamController::class);
    Route::get('teams', [TeamController::class, 'index']);
    Route::post('teams', [TeamController::class, 'store']);
    Route::post('/teams/{team_id}/users', [TeamController::class, 'addUser']);
    Route::delete('/teams/{team_id}/users/{user_id}', [TeamController::class, 'removeUser']);
});
