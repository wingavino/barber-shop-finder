<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'shop_id',
        'previous_ticket',
        'current_ticket',
        'next_ticket'
    ];

    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }

    public function ticket()
    {
      return $this->hasMany(Ticket::class);
    }
}
