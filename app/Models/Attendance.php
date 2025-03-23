<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = ['event_id', 'member_id', 'status', 'confirmed_by_parent'];

    public function event()
    {
        return $this->belongsTo(Events::class);
    }

    public function member()
    {
        return $this->belongsTo(Members::class);
    }
    public static function getStatusesForEvents($eventIds, $memberIds)
    {
        return static::whereIn('event_id', $eventIds)
            ->whereIn('member_id', $memberIds)
            ->get()
            ->groupBy(['event_id', 'member_id']);
    }

}
