<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create($request->validated());

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->respondToken($token);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if(is_null($user) || Hash::check($request->password, $user->papssword)) {
            return response()->json(['error' => ['message' => 'Incorrect credentials']], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->respondToken($token);
    }

    private function respondToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
