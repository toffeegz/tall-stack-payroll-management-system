<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\SssContributionModel;
use App\Models\SssContributionRate;

class TaxContributionComponent extends Component
{
    public function render()
    {
        return view('livewire.settings.tax-contribution-component',[
            'sss_contributions' => $this->sss_contribution_table,
        ]);
    }

    public function getSssContributionTableProperty()
    {
        return SssContributionRate::latest()->first();
    }
}
