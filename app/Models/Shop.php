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
        'owner_id',
        'lat',
        'lng',
        'approved',
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'owner_id');
    }

    public function open_hours()
    {
      return $this->hasMany(OpenHours::class);
    }

    public function shop_services()
    {
      return $this->hasMany(ShopServices::class);
    }

    public function image()
    {
      return $this->hasMany(Image::class);
    }
}
