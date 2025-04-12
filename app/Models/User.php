<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $table = 'tbl_user';
    protected $primaryKey = 'userid';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'gender',
        'jobid',
    ];

    // Implement JWTSubject methods
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Use the primary key as the identifier
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}