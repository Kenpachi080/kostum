<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $hidden = [
        'user_id', 'updated_at', 'created_at'
    ];
    protected $fillable = [
        'user_id',
        'city',
        'street',
        'house',
    ];

}
