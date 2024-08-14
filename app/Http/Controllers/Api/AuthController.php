<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    /**
     * Login user, email and password needed
     * Returning Bearer Token
     */
    public function login(ApiLoginRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password'])))
        {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
               'token' => $user->createToken(
                   'API Token for ' . $user->name,
                   ['*'],
                   now()->addDays(3)
               )->plainTextToken,
            ]
        );
    }

    /**
     * Logout user, token needed
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Logged out');
    }
}
