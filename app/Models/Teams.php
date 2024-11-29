<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Teams extends Model
{
    protected $table = 'teams'; 
    protected $fillable = [
        'name',
   
    ];
    use SoftDeletes;
    public function members()
    {
        return $this->belongsToMany(Members::class, 'member_team', 'team_id', 'member_id');
    }
    public function events()
    {
        return $this->belongsToMany(Events::class, 'event_team', 'team_id', 'event_id');
    }
}
