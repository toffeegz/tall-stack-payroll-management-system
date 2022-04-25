<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;

class Department extends Model
{
    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
