<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

use App\Models\Attendance;
use App\Models\Project;
use App\Models\Designation;
use App\Models\Payslip;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function formal_name()
    {
        return $this->last_name . ", " . $this->first_name . " " . ($this->middle_name ? $this->middle_name[0] : '');
    }

    public function informal_name()
    {
        return $this->first_name . " " . ($this->middle_name ? $this->middle_name[0] : '') . ". " . $this->last_name;
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function approveAttendancesBetweenDates($period_start, $period_end)
    {
        return $this->attendances->whereBetween('date', [$period_start, $period_end])
        ->whereNotIn('status', [4,5]);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

    public function designations()
    {
        return $this->belongsToMany(Designation::class, 'designation_user');
    }

    public function latestDesignation()
    {
        return $this->designations()->latest()->first();
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }


    // scope
    public function scopeSearch($query, $value) {
        return $query
            ->where('last_name', 'like', "%" . $value . "%")
            ->orWhere('first_name', 'like', "%" . $value . "%")
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
