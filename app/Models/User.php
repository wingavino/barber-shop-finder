<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'provider_id',
        'avatar',
        'type',
        'id_verified_at',
        'mobile_verified_at',
        'banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shop()
    {
      return $this->hasOne(Shop::class, 'owner_id');
    }

    public function employee()
    {
      return $this->hasOne(Employee::class);
    }

    public function pending_request()
    {
      return $this->hasMany(PendingRequest::class);
    }

    public function ticket()
    {
      return $this->hasMany(Ticket::class);
    }

    public function review()
    {
      return $this->hasMany(Review::class);
    }

    public function image()
    {
      return $this->hasMany(Image::class);
    }
}
