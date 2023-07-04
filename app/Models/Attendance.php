<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedBy;

use App\Models\User;
use App\Models\Project;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory, SoftDeletes, CreatedBy;

    protected $fillable = [
        'date', 
        'user_id', 
        'project_id',
        'time_in',
        'time_out',
        'regular',
        'late',
        'undertime',
        'overtime',
        'night_differential',
        'status',
        'created_by',
        'scheduled_time_in',
        'scheduled_time_out',
        'schedule_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeFilter($query, string $search)
    {
        $search = $search ?? false;
        $query->when($search ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $query->where('date', 'like', '%' . $search . '%')
                    ->where('time_in', 'like', '%' . $search . '%')
                    ->where('time_out', 'like', '%' . $search . '%');
                });
            }
        );
    }

    public function scopeFilterPending($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query->leftJoin('users', 'attendances.user_id', '=', 'users.id')
        ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $query->where('users.last_name', 'like', '%' . $search . '%')
                        ->orWhere('users.first_name', 'like', '%' . $search . '%')
                        ->orWhere('users.middle_name', 'like', '%' . $search . '%')
                        ->orWhere('users.code', 'like', '%' . $search . '%')
                        ->orWhere('attendances.date', 'like', '%' . $search . '%');
                });
            }
        );
    }

    public function getTimeInAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i a') : null;
    }

    public function getTimeOutAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i a') : null;
    }

}
