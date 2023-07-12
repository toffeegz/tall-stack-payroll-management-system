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

    public function render()
    {
        return view('livewire.payroll.preview-component', [
            'collection' => $this->collection,
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
        } else {
            foreach($this->users as $user)
            {
                $this->userData($user);
            }
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
            $collection[$user->id][] = $user_collection;
        }
        dd($collection[1]);
    }
}
