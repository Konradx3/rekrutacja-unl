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
     * Login
     *
     * Authenticates the user and return user API token.
     *
     * @unauthenticated
     * @group Authentication
     * @response 200 {"data": {
     * "token": "{YOUR_AUTH_KEY}"
     * },
     * "message": "Authenticated",
     * "status": 200
     * }
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
     * Logout
     *
     * Logout user and destroy API token
     *
     * @group Authentication
     * @response 200 {}
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Logged out');
    }
}
