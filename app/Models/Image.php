<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
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
        'path',
        'type',
    ];

    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
