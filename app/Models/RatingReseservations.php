<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReseservations extends Model
{
    use HasFactory;
    protected $fillable = [
        'rating',
        'note',
        'user_id',
        'chef_id',
        'reservations_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id', 'id');
    }
    public function reservations()
    {
        return $this->belongsTo(Reservation::class, 'reservations_id', 'id');
    }
}
