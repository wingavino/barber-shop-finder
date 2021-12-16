<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
      'user_id',
      'request_type',
      'change_to_user_type',
      'shop_id',
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
