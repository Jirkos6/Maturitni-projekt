<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    protected $table = 'achievements'; 
    protected $fillable = [
        'name',
        'image',
        'description',
        'url',
    ];
    use SoftDeletes;
}
