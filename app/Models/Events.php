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
        return $this->belongsToMany(Teams::class, 'event_team');
    }
}
