<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableRules extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['table', 'field', 'type'];
}
