<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth; // Import JWTAuth facade

class AuthController extends Controller
{
    public function __construct()
    {
        // No authentication required for login
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Login user and return JWT token.
     */
    public function login(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Predefined credentials
        $predefinedCredentials = [
            'username' => 'bershka',
            'password' => 'bershka'
        ];

        // Check credentials
        if ($request->username !== $predefinedCredentials['username'] || 
            $request->password !== $predefinedCredentials['password']) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Generate token using JWTAuth for a dummy user
        $dummyUser = (object) ['id' => 1, 'username' => 'bershka'];
        $token = JWTAuth::fromUser($dummyUser);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated user.
     */
    public function me()
    {
        return response()->json(['user' => Auth::user()]);
    }

    /**
     * Logout the user (invalidate token).
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh and return a new token.
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Structure the JWT response.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => Auth::user(),
            'expires_in' => config('jwt.ttl') * 60 // Default expiration time in seconds
        ]);
    }
}
