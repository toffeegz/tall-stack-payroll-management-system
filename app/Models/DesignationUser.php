<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Designation;

class DesignationUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'designation_user';

    protected $fillable = ['user_id', 'designation_id', 'created_at', 'updated_at'];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
