<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersAchievement extends Model
{
    protected $table = 'member_achievement'; 
    protected $fillable = [
        'member_id',
        'achievement_id',
    ];
}
