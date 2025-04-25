<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'gender',
        'avatar',
        'role_id',
        'coins',
        'lives',
        'current_streak',
        'longest_streak',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        // if (!empty($value) && !Hash::check($value, $this->attributes['password'])) {
        //     $this->attributes['password'] = Hash::make($value);
        // }
        // else {
        //     $this->attributes['password'] = $value;
        // }
        $this->attributes['password'] = $value;
    }

    // JWT functions
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'registration_date' => 'datetime',
        'is_active' => 'boolean',
        'coins' => 'integer',
        'lives' => 'integer',
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    public function checkins()
    {
        return $this->hasMany(CheckIn::class, 'user_id');
    }
}
