<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'price', 'status', 'type',
        'type_payment', 'user_id', 'type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
