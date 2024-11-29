<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MembersTeam extends Model
{
    protected $table = 'members_team'; 
    protected $fillable = [
        'name',
   
    ];
    use SoftDeletes;
}
