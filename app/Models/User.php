<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Timekeeper;
use App\Models\Attendance;
use App\Models\Project;
use App\Models\Designation;
use App\Models\DesignationUser;
use App\Models\Payslip;
use App\Models\TaxContribution;
use App\Models\Loan;
use App\Models\LoanInstallment;
use App\Models\Leave;

class User extends Authenticatable
{
    use SoftDeletes;
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

    protected $appends = ['formal_name'];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $query->where('last_name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('middle_name', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
        );
    }

    public function getFormalNameAttribute()
    {
        return $this->last_name . ', ' . $this->first_name . ' ' . ($this->middle_name ? $this->middle_name[0] : '');
    }

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

    public function project()
    {
        return $this->projects()->latest('updated_at')->first();
    }

    public function designations()
    {
        return $this->belongsToMany(Designation::class, 'designation_user')->withTimestamps();
    }

    public function latestDesignation()
    {
        // return $this->designations()->latest()->first();
        $latest_record = DB::table('designation_user')->where('user_id', $this->id)->latest('created_at')->first();
        if($latest_record){
        return $this->designations()->find($latest_record->designation_id);
        } else {
            return null;
        }
    }

    public function designationUsers()
    {
        return $this->hasMany(DesignationUser::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function taxContributions()
    {
        return $this->hasMany(TaxContribution::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanInstallments()
    {
        return $this->hasMany(LoanInstallment::class);
    }

    public function timeekeepers()
    {
        return $this->hasMany(Timekeeper::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
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
