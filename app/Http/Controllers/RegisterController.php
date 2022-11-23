<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(
        protected User $user
    ) {
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->user->create($request->validated());
        $user->sendEmailVerificationNotification();
        return response()->json([
            'user' => UserResource::make($user),
            'token' => $user->createToken('general')->plainTextToken
        ]);
    }
}
