<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'chef_id',
        'rating',
        'wasfa_id',
        'note',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id', 'id');
    }
    public function wasfa()
    {
        return $this->belongsTo(WasfaUser::class, 'wasfa_id', 'id');
    }
}
