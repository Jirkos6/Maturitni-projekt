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
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function events()
    {
        return $this->belongsToMany(Events::class, 'attendances')
                    ->withPivot('status', 'confirmed_by_parent')
                    ->withTimestamps();
    }
    public function getAttendanceStatus($eventId)
    {
        $attendance = Attendance::where('member_id', $this->id)
                                            ->where('event_id', $eventId)
                                            ->first();
        
        return $attendance ? $attendance->status : null;
    }
}
