<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;

class LeaveType extends Model
{
    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
}
