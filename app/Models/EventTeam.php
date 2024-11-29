<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EventTeam extends Model
{
    protected $table = 'event_team'; 
    protected $fillable = [
        'id',
        'event_id',
        'team_id'
    ];
    use SoftDeletes;
  
}
