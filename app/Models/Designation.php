<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;

class Designation extends Model
{
    //
    public function users()
    {
        return $this->belongsToMany(User::class, 'designation_user');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
