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
        'owner_name',
        'mobile',
        'address',
        'lat',
        'lng',
        'shop_verified_at',
        'hidden',
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'owner_id');
    }

    public function open_hours()
    {
      return $this->hasMany(OpenHours::class);
    }

    public function queue()
    {
      return $this->hasOne(Queue::class);
    }

    public function shop_services()
    {
      return $this->hasMany(ShopServices::class);
    }

    public function employee()
    {
      return $this->hasMany(Employee::class);
    }

    public function image()
    {
      return $this->hasMany(Image::class);
    }

    public function review()
    {
      return $this->hasMany(Review::class);
    }
}
