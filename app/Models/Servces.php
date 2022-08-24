<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servces extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discription',
        'status',
        'price', 'day', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function subscribe()
    {
        return $this->hasMany(Servce_user::class, 'service_id', 'id');
    }
}
