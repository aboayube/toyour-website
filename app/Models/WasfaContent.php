<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasfaContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'status',
        'wasfa_id',
        'image',
        'image_id',
    ];


    public function wasfa()
    {
        return $this->belongsTo(Wasfa::class, 'wasfa_id', 'id');
    }
}
