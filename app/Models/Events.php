<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events'; 
    protected $fillable = [
        'title',
        'description',
        'end_date',
        'start_date',
        'is_recurring',
   
    ];
    use SoftDeletes;
    public function recurringEvent()
    {
        return $this->hasOne(RecurringEvents::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Teams::class, 'event_team', 'event_id', 'team_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'event_id');
    }

    public function members()
    {
        return $this->belongsToMany(Members::class, 'attendances')
                    ->withPivot('status', 'confirmed_by_parent');
    }
}
