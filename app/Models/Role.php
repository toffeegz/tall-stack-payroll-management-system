<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Role extends LaratrustRole
{
    use HasFactory;
    
    const ADMINISTRATOR_ID = 1;
    const TIMEKEEPER_ID = 2;
    
    public $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
