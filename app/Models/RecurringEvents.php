<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RecurringEvents extends Model
{
    protected $table = 'recurring_events'; 
    protected $fillable = [
        'event_id',
        'frequency',
        'day_of_week',
        'day_of_month',
        'end_date',
        'repeat_count'
   
    ];
    use SoftDeletes;
    public function event()
    {
        return $this->belongsTo(Events::class);
    }
}
