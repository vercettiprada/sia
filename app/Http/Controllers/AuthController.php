<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    private $users = [
        'bershka' => 'password123',
        'anotheruser' => 'anotherpassword'
    ];

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (isset($this->users[$credentials['username']]) && $this->users[$credentials['username']] === $credentials['password']) {
            // Create a User instance
            $user = new User(['username' => $credentials['username']]);

            // Generate JWT token
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
