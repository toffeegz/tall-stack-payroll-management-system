<?php

namespace App\Http\Livewire\Payroll;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PayrollPeriod;
use App\Models\PayrollLog;
use App\Models\User;
use Carbon\Carbon;
use App\Services\Payroll\PayrollServiceInterface;

class PreviewComponent extends Component
{
    public $payroll_period_id;
    public $payroll_period_start;
    public $payroll_period_end;
    private $payrollService;
    public $search;
    // modal
    public $selected_user_id = null;
    public $selected_type = null;

    public function render()
    {
        $this->collection = collect($this->collection)->filter(function ($data) {
            return $this->search === null || str_contains(strtolower($data['name']), strtolower($this->search));
        });
        return view('livewire.payroll.preview-component', [
            'collection' => $this->collection,
            'search' => $this->search,
        ]);
    }

    public function mount(Request $request)
    {
        $this->payroll_period_id  = $request->payroll_period;
        $this->payroll_period = PayrollPeriod::find($this->payroll_period_id);
        if($this->payroll_period) {
            $this->payroll_period_start = $this->payroll_period->period_start;
            $this->payroll_period_end = $this->payroll_period->period_end;
            $this->savedPayrollData();
        } else {
            // if no payroll period found return 404 not found
            return abort(404);
        }
    }

    public function savedPayrollData()
    {
        $data = PayrollLog::where('period_start', $this->payroll_period_start)->where('period_end', $this->payroll_period_end)->first();
        if($data) {
            $this->payroll = json_decode($data['data'], true);
            $this->timestamp_saved_payroll = Carbon::parse($data->updated_at)->format('Y d M h:i:s a');
        } 
    }

    public function getLatestPayrollPeriodProperty()
    {
        return PayrollPeriod::latest('period_end')
        ->where('is_payroll_generated', false)
        ->first();
    }

    public function getPreviousPayrollsProperty()
    {
        return PayrollPeriod::latest('period_end')
        ->where('frequency_id', $this->selected_frequency_id)
        ->get();
    }

    public function getCollectionProperty(PayrollServiceInterface $payrollService)
    {
        // get user 
        $users =  User::where('is_active', true)
        ->where('frequency_id', $this->payroll_period->frequency_id)
        ->get();

        $collection = [];
        foreach($users as $user) {
            $user_collection = $payrollService->previewPayrollByUser($user, $this->payroll_period_start, $this->payroll_period_end);
            $collection[$user->id] = $user_collection;
        }
        return $collection;
    }

    public function saveForLater()
    {
        if($this->collection)
        {
            $data = PayrollLog::firstOrNew([
                'period_start' => $this->payroll_period_start,
                'period_end' => $this->payroll_period_end,
            ]);
            $data->data = json_encode($this->collection);
            $data->updated_at = Carbon::now();
            $data->save();
        }
    }

    public function submitPayroll()
    {
        $this->saveForLater();
        $data = PayrollLog::where('period_start', $this->payroll_period_start)->where('period_end', $this->payroll_period_end)->first();
        return redirect()->route('payroll.review', ['id'=>$data->id]);
    }

    // MODALS
    public function openAdditionalEarningsModal($user_id)
    {
        $this->selected_user_id = $user_id;
        $this->emit('openAdditionalEarningsModal');
    }

    public function openAdditionalDeductionsModal($user_id)
    {
        $this->selected_user_id = $user_id;
        $this->emit('openAdditionalDeductionsModal');
    }

    public function submitAdditionalEarnings()
    {
        $this->validate(['selected_type' => 'required']);
        $this->collection = $this->collection->map(function ($item) {
            if ($item['user_id'] === $this->selected_user_id) {
                $item['additional_earnings'][$this->selected_type]['visible'] = true;
            }
            return $item;
        });
    
        $this->selected_type = null;
        $this->selected_user_id = null;
        $this->emit('closeAdditionalEarningsModal');
    }

    public function submitAdditionalDeductions()
    {
        $this->validate(['selected_type' => 'required']);
        $this->collection = $this->collection->map(function ($item) {
            if ($item['user_id'] === $this->selected_user_id) {
                $item['deductions'][$this->selected_type]['visible'] = true;
            }
            return $item;
        });
    
        $this->selected_type = null;
        $this->selected_user_id = null;
        $this->emit('closeAdditionalDeductionsModal');
    }

    public function removeAdditionalEarnings($type_id, $user_id)
    {
        $this->collection = $this->collection->map(function ($item) use ($type_id, $user_id){
            if($item['user_id'] === $user_id) {
                $item['additional_earnings'][$type_id]['visible'] = false;
                $item['additional_earnings'][$type_id]['amount'] = null;
            }
            return $item;
        });
    }

    public function removeDeductions($type_id, $user_id)
    {
        $this->collection = $this->collection->map(function ($item) use ($type_id, $user_id){
            if($item['user_id'] === $user_id) {
                $item['deductions'][$type_id]['visible'] = false;
                $item['deductions'][$type_id]['amount'] = null;
            }
            return $item;
        });
    }
}
