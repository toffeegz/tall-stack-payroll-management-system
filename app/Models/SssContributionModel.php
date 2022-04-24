<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SssContributionRate;

class SssContributionModel extends Model
{
    use HasFactory;

    public function sss_rate()
    {
        return $this->belongsTo(SssContributionRate::class);
    }
}
