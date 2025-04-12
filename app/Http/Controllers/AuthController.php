<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hardcoded credentials
    private $users = [
        'bershka' => 'password123',
        'anotheruser' => 'anotherpassword'
    ];

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Check if the credentials match the hardcoded users
        if (isset($this->users[$credentials['username']]) && $this->users[$credentials['username']] === $credentials['password']) {
            // Generate JWT token
            $token = JWTAuth::fromUser((object) ['username' => $credentials['username']]);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
