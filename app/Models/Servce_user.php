<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servce_user extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'service_id', 'end_at'];
    protected $dates = ['end_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Servces::class);
    }
}
