<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wasfa extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discription',
        'status',
        'image',
        'price',
        'user_id',
        'category_id',
        'time_make',
        'advertise',
        'number_user',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function wasfa_content()
    {
        return $this->hasMany(WasfaContent::class);
    }
    public function wasfa_users()
    {
        return $this->hasMany(WasfaUser::class, 'wasfa_id', 'id');
    }
}
