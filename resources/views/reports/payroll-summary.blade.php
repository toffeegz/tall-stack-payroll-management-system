<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="15">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="15">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="15">Payroll Summary Report ({{ $data['frequency_id'] == 1 ? 'Semi-Monthly':'Weekly'}})</td></tr>
        <tr>
            <td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="15">
                Period Date: {{ Carbon\Carbon::parse($data['period_start'])->format('M d, Y') }} to {{ Carbon\Carbon::parse($data['period_end'])->format('M d, Y') }} 
            </td>
        </tr>
        <tr>
            <td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="15">
                Payout Date: {{ Carbon\Carbon::parse($data['payout_date'])->format('M d, Y') }} 
            </td>
        </tr>
    <tr>
        <td style="border:none; font-size:12pt;" colspan="15">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="15">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    {{--  --}}
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize; text-align:right;" colspan="9">
            
        </td>
        <td colspan="2" style="border:1px solid rgb(88, 88, 88); font-size:12pt; font-weight: bold; text-align: center;">
            EARNINGS
        </td>
        <td colspan="2" style="border:1px solid rgb(88, 88, 88); font-size:12pt; font-weight: bold; text-align: center;">
            DEDUCTIONS
        </td>
        <td colspan="2" style="border:1px solid rgb(88, 88, 88); font-size:12pt; font-weight: bold; text-align: center;">
            NET PAY
        </td>
    </tr>
    <tr>
        <td style="border:none; text-transform:capitalize; text-align:right; font-weight: bold;" colspan="9">
            TOTAL
        </td>
        <td style="border:none; text-transform:capitalize; text-align:right; font-weight: bold;" colspan="2">
            {{ number_format($collection->sum('gross_pay'), 2, '.', ',') }}
        </td>
        <td style="border:none; text-transform:capitalize; text-align:right; font-weight: bold;" colspan="2">
            {{ number_format($collection->sum('deductions'), 2, '.', ',') }}
        </td>
        <td style="border:none; text-transform:capitalize; text-align:right; font-weight: bold;" colspan="2">
            {{ number_format($collection->sum('net_pay'), 2, '.', ',') }}
        </td>
    </tr>
    {{--  --}}
    <tr>
        <td colspan="15"></td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="9" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">EMPLOYEE INFORMATION</td>
        <td colspan="7" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">ATTENDANCE</td>
        <td colspan="6" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">EARNINGS</td>
        <td colspan="7" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">DEDUCTIONS</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">TOTAL</td>
        
        <td rowspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Net Pay</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Signature</td>
    
    </tr>
    <tr >
        <td colspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Name</td>
        <td colspan="1" style="border:1px solid #000; font-weight: 500; text-align: center;">ID</td>
        <td colspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Position</td>
        <td colspan="3" style="border:1px solid #000; font-weight: 500; text-align: center;">Project</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Daily Rate</td>

        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Regular</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Overtime</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Night Diff</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Restday</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Restday OT</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Late</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Undertime</td>
        
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Basic Pay</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">OT Pay</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Holiday Pay</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">SOT Pay</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">ND Pay</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Adjustment</td>

        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Tardiness</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Cash Advances</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">SSS</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">SSS Loan</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">HDMF</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">HDMF Loan</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">PHIC</td>

        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Earnings</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">Deductions</td>

    </tr>
    <tbody>
        @foreach($collection as $payslip)
            <tr>
                <?php 
                    $labels = json_decode($payslip->labels, true);
                    $daily_rate = $labels['daily_rate'];
                    $attendance = $labels['hours'];
                    $earnings = $labels['earnings'];
                    $holiday = $earnings['holiday'];
                    $holiday_pay = $holiday['legal'] + $holiday['legal_ot'] + $holiday['special'] + $holiday['special_ot'] + $holiday['double'] + $holiday['double_ot'];

                    $deductions = $labels['deductions'];
                    $tax_contribution = $deductions['tax_contribution'];

                ?>
                <td colspan="2" style="">{{ $payslip->user->formal_name() }}</td>
                <td style="text-align: center;">{{ $payslip->user->code }}</td>
                <td colspan="2" style="">{{ $labels['designation'] }}</td>
                <td colspan="3" style="">Project</td>
                <td style="">{{ number_format($daily_rate, 2, '.', ',') }}</td>

                <td style="">{{ $attendance['regular'] }}</td>
                <td style="">{{ $attendance['overtime'] }}</td>
                <td style="">{{ $attendance['night_differential'] }}</td>
                <td style="">{{ $attendance['restday'] }}</td>
                <td style="">{{ $attendance['restday_ot'] }}</td>
                <td style="">{{ $attendance['late'] }}</td>
                <td style="">{{ $attendance['undertime'] }}</td>
                
                <td style="">{{ number_format($payslip->basic_pay, 2, '.', ',') }}</td>
                <td style="">{{ number_format($earnings['overtime_pay'], 2, '.', ',') }}</td>
                <td style="">{{ number_format($holiday_pay, 2, '.', ',') }}</td>
                <td style="">{{ number_format($earnings['restday_pay'], 2, '.', ',') }}</td>
                <td style="">{{ number_format($earnings['restday_ot_pay'], 2, '.', ',') }}</td>
                <td style="">{{ number_format($earnings['night_diff_pay'], 2, '.', ',') }}</td>

                <td style="">{{ number_format($payslip->tardiness, 2, '.', ',') }}</td>
                <td style="">{{ number_format($deductions['cash_advance'], 2, '.', ',') }}</td>

                <td style="">{{ number_format($tax_contribution['sss'], 2, '.', ',') }}</td>
                <td style="">{{ number_format($deductions['sss_loan'], 2, '.', ',') }}</td>
                
                
                <td style="">{{ number_format($tax_contribution['hdmf'], 2, '.', ',') }}</td>
                <td style="">{{ number_format($deductions['hdmf_loan'], 2, '.', ',') }}</td>
                <td style="">{{ number_format($tax_contribution['phic'], 2, '.', ',') }}</td>

                <td style="">{{ number_format($payslip->gross_pay, 2, '.', ',') }}</td>
                <td style="">{{ number_format($payslip->deductions, 2, '.', ',') }}</td>
                <td style="">{{ number_format($payslip->net_pay, 2, '.', ',') }}</td>
                <td style="" colspan="2"></td>
            </tr>
        @endforeach
    </tbody>
</table>