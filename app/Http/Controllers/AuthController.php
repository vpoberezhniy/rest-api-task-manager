<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Log the user out (Invalidate the token).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Відкликати токен користувача
        Auth::guard('sanctum')->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
