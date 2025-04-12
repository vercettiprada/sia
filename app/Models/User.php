<?php

namespace App\Models;

// Change the base class to Eloquent Model
use Illuminate\Database\Eloquent\Model;
// Import the Authenticatable CONTRACT and TRAIT
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
// Import JWTSubject Contract
use Tymon\JWTAuth\Contracts\JWTSubject;

// Extend Model, implement both contracts
class User extends Model implements AuthenticatableContract, JWTSubject
{
    // Use the trait to implement AuthenticatableContract methods
    use AuthenticatableTrait;

    // --- Existing properties ---
    protected $table = 'tbl_user';
    protected $primaryKey = 'userid';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'gender',
        'jobid',
    ];

    protected $hidden = [
        'password',
    ];

    // --- JWTSubject Methods (already correct) ---
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // Use getAuthIdentifier() from the trait, which respects $primaryKey
        // Or keep the direct access if preferred, but getAuthIdentifier is safer
        // return $this->{$this->primaryKey};
         return $this->getKey(); // getKey() uses the defined primaryKey
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // --- AuthenticatableContract Methods (provided by AuthenticatableTrait) ---
    // You might need to ensure your 'password' column is handled correctly
    // The trait usually expects 'password' for getAuthPassword()
    // No explicit methods needed here if using the trait correctly.

    // Add this if your password column name is different and not handled by the trait automatically
    // public function getAuthPassword() {
    //    return $this->password;
    // }

}