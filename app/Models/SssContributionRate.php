<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SssContributionModel;

class SssContributionRate extends Model
{
    use HasFactory;
    public function sss_contributions()
    {
        return $this->hasMany(SssContributionModel::class);
    }
}
