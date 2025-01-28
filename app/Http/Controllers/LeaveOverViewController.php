<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveOverViewController extends Controller
{


    public function show(Request $request)
    {
        $user = $request->user();

        // Fetch approved leaves with related leave types
        $leaves = $user->leaves()
            ->where('status', 'approved')
            ->with('leaveType')
            ->get();

        // TODO: Get total leave hours from user's contract or some other source
        // For now, we'll assume the user has 40 days of leave
        $total_leave = 40 * 8;
        $used_leave = 0;

        //Here we loop through the leaves and calculate the used leave hours
        foreach ($leaves as $leave) {

            // This check is to see if it for a full day
            if ($leave->date_return == null) {
                // If it is a full day, we add 8 hours to the used leave
                $used_leave += 8;
            } else {
                // If it is not a full day, we calculate the hours between the start and end date
                $used_leave +=
                    $this->calculateLeaveHours(
                        Carbon::parse($leave->date_leave)->format('Y-m-d H:i:s'),
                        Carbon::parse($leave->date_return)->format('Y-m-d H:i:s')
                    );
            }

        }

        return response()->json([
            'message' => 'Leave overview retrieved successfully',
            'leave_overview' => [
                'total_leaves' => $total_leave,
                'used_leaves' => $used_leave,
                'remaining_leaves' => $total_leave - $used_leave,
            ],
        ]);
    }

    private function calculateLeaveHours($start, $end)
    {
        // If the start and end date are the same, we return the difference in hours
        if (Carbon::parse($start)->format('Y-m-d') == Carbon::parse($end)->format('Y-m-d')) {
            return Carbon::parse($start)->diffInHours(Carbon::parse($end));
        }
        // If the start and end date are not the same, we return the difference in days multiplied by 8 hours (a full workday)
        else {
            return Carbon::parse($start)->diffInDays(Carbon::parse($end)) * 8;
        }
    }

}
