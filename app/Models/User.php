<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User implements JWTSubject
{
    public $username;

    public function __construct($attributes = [])
    {
        $this->username = $attributes['username'] ?? null;
    }

    // Implement JWTSubject methods
    public function getJWTIdentifier()
    {
        // Return a valid identifier, such as the username
        return $this->username;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}