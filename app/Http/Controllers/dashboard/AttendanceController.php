<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function updateAttendance(Request $request)
    {
        try {
            $validated = $request->validate([
                'member_id' => 'required|exists:members,id',
                'event_id' => 'required|exists:events,id',
                'status' => 'required|in:present,excused,unexcused',
            ], [], [
                'member_id' => 'člen',
                'event_id' => 'akce',
                'status' => 'stav účasti'
            ]);

            $attendance = Attendance::where('member_id', $validated['member_id'])
                ->where('event_id', $validated['event_id'])
                ->first();

            if ($attendance) {
                $attendance->status = $validated['status'];
                $attendance->save();
            } else {
                Attendance::create([
                    'member_id' => $validated['member_id'],
                    'event_id' => $validated['event_id'],
                    'status' => $validated['status'],
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
