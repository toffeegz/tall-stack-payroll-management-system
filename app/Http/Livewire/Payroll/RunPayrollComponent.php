<?php

namespace App\Http\Livewire\Payroll;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PayrollPeriod;
use App\Models\PayrollLog;
use App\Models\Earning;
use App\Models\Deduction;
use App\Models\User;
use Helper;
use Carbon\Carbon;

class RunPayrollComponent extends Component
{
    public $payroll_period_id;
    public $payroll_period_start;
    public $payroll_period_end;
    public $search = "";

    public array $payroll = [];
    public $allHours = [];

    // hours
    public $regular_hours;

    // modal
    public $selected_user_id = null;
    public $selected_user_name;
    public $selected_type = null;

    // SEARCH
    public $search_employee_payroll = "";

    // SAVED PAYROLL
    public $timestamp_saved_payroll;
    public $payroll_logs_id;

    public function render()
    {
        return view('livewire.payroll.run-payroll-component', [
            'payroll' => $this->payroll,
            'earning_types' => $this->earning_types,
            ])
        ->layout('layouts.app',  ['menu' => 'payroll']);
    }

    public function mount(Request $request)
    {
        $this->payroll_period_id  = $request->payroll_period;
        $this->payroll_period = PayrollPeriod::find($this->payroll_period_id);

        if($this->payroll_period)
        {
            $this->payroll_period_start = $this->payroll_period->period_start;
            $this->payroll_period_end = $this->payroll_period->period_end;

            $this->savedPayrollData();
            // dd($this->payroll);
            // dd($this->earning_types);
            // dd($this->deduction_types);

        } else {
            // if no payroll period found return 404 not found
            return abort(404);
        }
    }

    // FETCH FROM DB
    public function getUsersProperty()
    {
        $search = $this->search;

        return User::where('employee_status', 1)
        ->where('frequency_id', $this->payroll_period->frequency_id)
        ->get();
    }

    public function getEarningTypesProperty()
    {
        return Earning::where('active', true)->get();
    }

    public function getDeductionTypesProperty()
    {
        return Deduction::where('active', true)->get();
    }

    // PAYROLL DATA

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
    

    public function userData($user)
    {
        

        
        $total_hours = Self::getAttendanceHoursAndDeductions($user)['total_hours'];
        
        // cash advance
        $loan = Helper::getCashAdvanceAmountToPay($user->id);
            

        // deductions 
            $deductions = [];
            foreach($this->deduction_types as $deduction_type)
            {
                $deductions[$deduction_type->id] = [
                    'name' => $deduction_type->name,
                    'acronym' => $deduction_type->acronym,
                    'amount' => null,
                    'visible' => false,
                ];
            }
            // 
    
            $deduction_hours = Self::getAttendanceHoursAndDeductions($user)['deductions'];
        
            foreach($deduction_hours as $val)
            {
                $deductions[] = $val;
            }
        
            if($loan != 0){
                $deductions[] = [
                    'name' => 'Loan',
                    'acronym' => 'lo',
                    'amount' => $loan,
                    'visible' => Self::amountVisibleChecker($loan),
                ];
            } 
        // 
        
        

        // daily rate
            $latest_designation = $user->latestDesignation();
            $daily_rate = null;
            if($latest_designation)
            {
                $daily_rate = $latest_designation->daily_rate;
            }
        // 
        

        // additional earnings initial
            $additional_earnings = [];
            foreach($this->earning_types as $earning_type)
            {
                $additional_earnings[$earning_type->id] = [
                    'name' => $earning_type->name,
                    'acronym' => $earning_type->acronym,
                    'amount' => null,
                    'visible' => false,
                ];
            }
        // 
        
        $this->payroll[$user->id] = [
            'id' => $user->id,
            'full_name' => $user->formal_name(),
            'daily_rate' => $daily_rate,
            'visible' => true,
            'total_hours' => $total_hours,
            'additional_earnings' => $additional_earnings,
            'deductions' => $deductions, 
        ];
    }

    public function searchPayroll()
    {
        $search = $this->search_employee_payroll;
        $data = $this->payroll;

        foreach ($data as $key => $val) {
            if($search != "")
            {
                if(preg_match("/{$search}/i", $val['full_name'])) {
                    $this->payroll[$key]['visible'] = true;
                } else {
                    $this->payroll[$key]['visible'] = false;
                }
            } 
            else 
            {
                $this->payroll[$key]['visible'] = true;
            }
        }
    }

    public function getAttendanceHoursAndDeductions($user)
    {

        $hours = $user->approveAttendancesBetweenDates($this->payroll_period_start, $this->payroll_period_end);
        
        // HOURS
            $regular = $hours->whereIn('status', [1,2])->sum('regular');
            $overtime = $hours->whereIn('status', [1,2])->sum('overtime');
            $night_differential = $hours->sum('night_differential');
            $restday = $hours->where('status', 3)->sum('regular');
            $restday_ot = $hours->where('status', 3)->sum('overtime');
        // 
        // DEDUCTIONS
            // deduct hours
            $late = $hours->sum('late');
            $undertime = $hours->sum('undertime');

        // 

        $data['total_hours'] = [
            1 => [
                'name' => 'Regular',
                'acronym' => 'rh',
                'amount' => $regular,
                'visible' => Self::amountVisibleChecker($regular),
            ],
            2 => [
                'name' => 'Overtime',
                'acronym' => 'ot',
                'amount' => $overtime,
                'visible' => Self::amountVisibleChecker($overtime),
            ],
            3 => [
                'name' => 'Restday',
                'acronym' => 'rd',
                'amount' => $restday,
                'visible' => Self::amountVisibleChecker($restday),
            ],
            4 => [
                'name' => 'RestdayOT',
                'acronym' => 'rdot',
                'amount' => $restday_ot,
                'visible' => Self::amountVisibleChecker($restday_ot),
            ],
            5 => [
                'name' => 'Night Diff',
                'acronym' => 'nd',
                'amount' => $night_differential,
                'visible' => Self::amountVisibleChecker($night_differential),
            ],
        ];

        $data['deductions'] = [
            [
                'name' => 'Late',
                'acronym' => 'la',
                'amount' => $late,
                'visible' => Self::amountVisibleChecker($late),
            ],
            [
                'name' => 'Undertime',
                'acronym' => 'ut',
                'amount' => $undertime,
                'visible' => Self::amountVisibleChecker($undertime),
            ],
        ];
        return $data;
    }

    public function amountVisibleChecker($amount)
    {
        if($amount == 0){
            return false;
        } else {
            return true;
        }
    }

    // SUBMIT PAYROLL

    public function saveForLater()
    {
        // dd($this->payroll);
        if($this->payroll)
        {
            $data = PayrollLog::firstOrNew([
                'period_start' => $this->payroll_period_start,
                'period_end' => $this->payroll_period_end,
            ]);
            $data->data = json_encode($this->payroll);
            $data->updated_at = Carbon::now();
            $data->save();
            return redirect(request()->header('Referer'));
        }
    }

    public function submit()
    {
        $data = PayrollLog::where('period_start', $this->payroll_period_start)->where('period_end', $this->payroll_period_end)->first();
        if($data) {
            return redirect()->route('payroll.review', ['id'=>$data->id]);
        }
    }

    // MODAL OPEN

    public function openTotalHoursModal($user_id)
    {
        $this->selected_user_name = $this->users->where('id', $user_id)->first()->formal_name();
        $this->selected_user_id = $user_id;
        $this->emit('openTotalHoursModal');
    }

    public function openAdditionalEarningsModal($user_id)
    {
        $this->selected_user_name = $this->users->where('id', $user_id)->first()->formal_name();
        $this->selected_user_id = $user_id;
        $this->emit('openAdditionalEarningsModal');
    }

    public function openDeductionsModal($user_id)
    {
        $this->selected_user_name = $this->users->where('id', $user_id)->first()->formal_name();
        $this->selected_user_id = $user_id;
        $this->emit('openDeductionsModal');
    }

    // SUBMIT

    public function submitTotalHours()
    {
        $this->validate(['selected_type' => 'required']);
        $this->payroll[$this->selected_user_id]['total_hours'][$this->selected_type]['visible'] = true;
        $this->selected_type = null;
    }

    public function submitAdditionalEarnings()
    {
        $this->validate(['selected_type' => 'required']);
        $this->payroll[$this->selected_user_id]['additional_earnings'][$this->selected_type]['visible'] = true;
        $this->selected_type = null;
    }

    public function submitDeductions()
    {
        $this->validate(['selected_type' => 'required']);
        $this->payroll[$this->selected_user_id]['deductions'][$this->selected_type]['visible'] = true;
        $this->selected_type = null;
    }

    // REMOVE

    public function removeTotalHours($type_id, $user_id)
    {
        $this->payroll[$user_id]['total_hours'][$type_id]['visible'] = false;
        $this->payroll[$user_id]['total_hours'][$type_id]['amount'] = null;
    }

    public function removeAdditionalEarnings($type_id, $user_id)
    {
        $this->payroll[$user_id]['additional_earnings'][$type_id]['visible'] = false;
        $this->payroll[$user_id]['additional_earnings'][$type_id]['amount'] = null;
    }

    public function removeDeductions($type_id, $user_id)
    {
        $this->payroll[$user_id]['deductions'][$type_id]['visible'] = false;
        $this->payroll[$user_id]['deductions'][$type_id]['amount'] = null;
    }
    

}
