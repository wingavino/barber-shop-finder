<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'shop_id',
        'user_id',
        'name',
        'type',
    ];

    public function shop()
    {
      return $this->hasOne(Shop::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
