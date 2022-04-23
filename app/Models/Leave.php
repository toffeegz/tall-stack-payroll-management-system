<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveType;
use App\Models\User;

class Leave extends Model
{


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
