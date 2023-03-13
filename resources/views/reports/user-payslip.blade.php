<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="8">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="8">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="8">Payslip</td></tr>
        
    <tr>
        <td style="border:none; font-size:12pt;" colspan="8">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="8">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="3" style=" font-size:12pt; font-weight: bold; ">EMPLOYEE INFORMATION</td>
        <td></td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Pay Date</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Pay Period</td>
    </tr>
    
    <tr>
        <td colspan="1" style=" font-size:12pt; font-weight: bold; ">ID</td>
        <td colspan="2">{{ $data['code'] }}</td>
        <td></td>
        <td colspan="2" style="border:1px solid #000; text-align: center;">{{ $data['payout_date'] }}</td>
        <td colspan="2" style="border:1px solid #000; text-align: center;">{{ $data['pay_period'] }}</td>
    </tr>

    <tr>
        <td colspan="1" style=" font-size:12pt; font-weight: bold; ">Name</td>
        <td colspan="2">{{ $data['full_name'] }}</td>
        <td></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
    </tr>

    <tr>
        <td colspan="1" style=" font-size:12pt; font-weight: bold; ">Job Title</td>
        <td colspan="2">{{ $data['designation'] }}</td>
        <td colspan=""></td>
        <td colspan=""></td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">NET PAY</td>
        <td colspan="2" style="border:1px solid #000; text-align: right; font-weight: bold; font-size: 12pt;">₱{{ number_format($data['net_pay'], 2, '.', '') }}</td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>

    {{-- earnings --}}
    <tr>
        <td colspan="3" style="border:1px solid #000; text-align: left; font-weight: bold; font-size: 12pt;">EARNINGS</td>
        <td colspan="1" style="border:1px solid #000; text-align: center; font-weight: bold; font-size: 12pt;">HRS</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; font-weight: bold; font-size: 12pt;">AMOUNT</td>
    </tr>
    {{-- basic pay --}}
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Basic Pay</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['basic_pay_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['basic_pay'], 2, '.', '') }}</td>
    </tr>
    {{-- overtime pay --}}
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Overtime Pay</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['overtime_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['overtime_pay'], 2, '.', '') }}</td>
    </tr>
    {{-- restday pay --}}
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Restday Pay</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['restday_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['restday_pay'], 2, '.', '') }}</td>
    </tr>

    {{-- restday_ot pay --}}
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Restday OT Pay</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['restday_ot_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['restday_ot_pay'], 2, '.', '') }}</td>
    </tr>

    @if($data['night_differential_pay'] != 0)
    {{-- night_diff pay --}}
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Night Diff Pay</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['night_differential_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['night_differential_pay'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- gross pay --}}
    <tr>
        <td colspan="4"></td>
        <td colspan="2" style="border:1px solid #000; text-align: left; font-weight: bold; font-size: 12pt;">GROSS PAY</td>
        <td colspan="2" style="border:1px solid #000; text-align: right; font-weight: bold; font-size: 12pt;">{{ number_format($data['gross_pay'], 2, '.', '')}}</td>
    </tr>

    <tr>
        <td colspan="8"></td>
    </tr>

    {{-- deductions --}}
    <tr>
        <td colspan="3" style="border:1px solid #000; text-align: left; font-weight: bold; font-size: 12pt;">DEDUCTIONS</td>
        <td colspan="1" style="border:1px solid #000; text-align: center; font-weight: bold; font-size: 12pt;">HRS</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; font-weight: bold; font-size: 12pt;">AMOUNT</td>
    </tr>

    {{-- late --}}
    
    @if($data['late'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Late</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['late_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['late'], 2, '.', '') }}</td>
    </tr>
    @endif
    {{-- undertime --}}
    @if($data['undertime'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Undertime</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;">{{ $data['undertime_hours'] }}</td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['undertime'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- absences --}}
    @if($data['absences'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Absences</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['absences'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- cash advance --}}
    @if($data['absences'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">Cash Advance (Loan)</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['cash_advance'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- sss loan --}}
    @if($data['sss_loan'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">SSS Loan</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['sss_loan'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- hdmf_loan --}}
    @if($data['hdmf_loan'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">HDMF Loan</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['hdmf_loan'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- SSS --}}
    @if($data['sss'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">SSS</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['sss'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- HDMF --}}
    @if($data['hdmf'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">HDMF</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['hdmf'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- PHIC --}}
    @if($data['phic'] != 0)
    <tr>
        <td colspan="3" style="text-align: left; border:1px solid #000; text-align: left;">PHIC</td>
        <td colspan="1" style="border:1px solid #000; text-align: center;"></td>
        <td colspan="4" style="border:1px solid #000; text-align: right; text-align: right;">{{ number_format($data['phic'], 2, '.', '') }}</td>
    </tr>
    @endif

    {{-- TOTAL DEDUCTIONS --}}
    <tr>
        <td colspan="4"></td>
        <td colspan="2" style="border:1px solid #000; text-align: left; font-weight: bold; font-size: 12pt;">TOTAL DEDUCTIONS</td>
        <td colspan="2" style="border:1px solid #000; text-align: right; font-weight: bold; font-size: 12pt;">{{ number_format($data['deductions'], 2, '.', '')}}</td>
    </tr>


</table>