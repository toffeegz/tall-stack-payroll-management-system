<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\SssContributionModel;
use App\Models\SssContributionRate;
use App\Models\HdmfContributionRate;
use App\Models\PhicContributionRate;
use Carbon\Carbon;

class TaxContributionComponent extends Component
{
    public function render()
    {
        return view('livewire.settings.tax-contribution-component',[
            'sss_contributions' => $this->sss_contribution_table,
            'hdmf_contributions' => $this->hdmf_contribution_table,
            'phic_contributions' => $this->phic_contribution_table,
        ]);
    }

    public function getSssContributionTableProperty()
    {
        return SssContributionRate::latest()->first();
    }

    public function getHdmfContributionTableProperty()
    {
        return HdmfContributionRate::where('year', Carbon::now()->format('Y'))->get();
    }

    public function getPhicContributionTableProperty()
    {
        return PhicContributionRate::where('year', Carbon::now()->format('Y'))->get();
    }
}
