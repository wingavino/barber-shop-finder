<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'owner_name',
        'lat',
        'lng',
        'location',
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'owner_id');
    }
}
