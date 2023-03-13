<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;

class Designation extends Model
{
    const HUMAN_RESOURCE_MANAGER = 2;
    const FULL_STACK_DEVELOPER_ID = 3;
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'designation_user');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
