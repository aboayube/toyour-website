<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'discription',
        'image', 'email', 'facebook', 'twiter', 'image_id',
        'linked_in', 'instagram', 'whatsapp', 'address',
    ];
}
