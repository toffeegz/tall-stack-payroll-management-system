<?php

namespace App\Services\Attendance;

interface AttendanceServiceInterface
{
    public function store($user_id, $project_id, $date, $time_in, $time_out);
    public function getHoursAttendance($date_attendance, $time_in_attendance, $time_out_attendance);
    public function getAttendanceStatus($date, $late_hours);
}
