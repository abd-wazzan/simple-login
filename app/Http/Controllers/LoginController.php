<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(
        protected User $user
    )
    {
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->user->findUserByEmail($request->input('email'));

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 422);
        }

        return response()->json([
            'user' => UserResource::make($user),
            'token' => $user->createToken('general')->plainTextToken
        ]);
    }
}
