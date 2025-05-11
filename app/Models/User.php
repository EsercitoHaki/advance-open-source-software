<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject, CanResetPasswordContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, \Illuminate\Auth\Passwords\CanResetPassword;

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

    public function sendPasswordResetNotification($token)
    {
        // Sử dụng notification mặc định
        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
        
        // Hoặc sử dụng notification tùy chỉnh nếu bạn muốn frontend tự xử lý
        // $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Get friend requests sent by the user
     * 
     * @return HasMany
     */
    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id', 'user_id');
    }

    /**
     * Get friend requests received by the user
     * 
     * @return HasMany
     */
    public function receivedFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id', 'user_id');
    }

    /**
     * Get friendships where user is user1
     * 
     * @return HasMany
     */
    public function friendsAsUser1(): HasMany
    {
        return $this->hasMany(Friend::class, 'user1_id', 'user_id');
    }

    /**
     * Get friendships where user is user2
     * 
     * @return HasMany
     */
    public function friendsAsUser2(): HasMany
    {
        return $this->hasMany(Friend::class, 'user2_id', 'user_id');
    }

    /**
     * Get all friends of the user
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function friends()
    {
        $friends1 = $this->friendsAsUser1()->with('user2')->get()->map(function ($friendship) {
            return $friendship->user2;
        });

        $friends2 = $this->friendsAsUser2()->with('user1')->get()->map(function ($friendship) {
            return $friendship->user1;
        });

        return $friends1->merge($friends2);
    }
}
