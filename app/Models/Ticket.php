<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'queue_id',
        'user_id',
        'ticket_number',
        'on_hold'
    ];

    public function queue()
    {
      return $this->belongsTo(Queue::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
