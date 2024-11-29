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

}
