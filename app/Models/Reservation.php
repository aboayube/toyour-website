<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'start_from',
        'end_from',
        'location',
        'number_user',
        'notes',
        'user_id',
        'chif_id',
        'status',
        'payment_status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chif()
    {
        return $this->belongsTo(User::class, 'chif_id', 'id');
    }
    public function rating()
    {
        return $this->belongsTo(RatingReseservations::class, 'reservations_id', 'id');
    }
}
