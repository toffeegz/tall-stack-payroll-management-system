<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Loan;
use App\Models\Attendance;
use App\Models\Timekeeper;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function usersImage($count)
    {
        return $this->users()->take($count)->get();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function timekeepers()
    {
        return $this->belongsToMany(Timekeeper::class, 'timekeepers', 'project_id', 'id');
    }

    // scope
    public function scopeSearch($query, $value) {
        return $query
            ->where('name', 'like', "%" . $value . "%")
            ->orWhere('code', 'like', "%" . $value . "%");
    }

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'like', '%'.$value.'%');
    }
}
