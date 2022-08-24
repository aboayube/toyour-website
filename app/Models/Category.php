<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status', 'user_id', 'image', 'image_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function wasfas()
    {
        return $this->hasMany(Wasfa::class);
    }
}
