<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = 'members'; 
    protected $fillable = [
        'name',
   
    ];
    use SoftDeletes;
    public function teams()
    {
        return $this->belongsToMany(Teams::class, 'member_team', 'member_id', 'team_id');
    }
}
