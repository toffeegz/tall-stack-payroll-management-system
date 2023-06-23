<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="15">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="15">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="15">Loan Export</td></tr>
        
    <tr>
        <td style="border:none; font-size:12pt;" colspan="15">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="15">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    
    {{--  --}}
    <tr>
        <td colspan="15"></td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Employee Information</td>
        <td colspan="2" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Status</td>
        <td colspan="2" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Reference No.</td>
        <td colspan="2" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Date Approved</td>
        <td colspan="1" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Auto Deduct</td>
        <td colspan="1" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Install Period</td>
        <td colspan="1" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Balance</td>
        <td colspan="1" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Loan amount</td>
        <td colspan="1" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Install Amount</td>
        
    </tr>
    <tr >
        <td colspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Name</td>
        <td colspan="1" style="border:1px solid #000; font-weight: 500; text-align: center;">ID</td>
    </tr>
    <tbody>
        @foreach($data as $value)
            @if($value->user)
            <tr>
                <td colspan="2">{{ $value->user->formal_name() }}</td>
                <td>{{ $value->user->code }}</td>
                <td colspan="2" style="text-align: center;">
                    @if($value->status == 1)
                        Pending
                    @elseif($value->status == 2)
                        Approved
                    @elseif($value->status == 3)
                        Disapproved
                    @endif
                </td>
                <td colspan="2" style="text-align:left;">{{ $value->reference_no }}</td>
                <td colspan="2" style="text-align: center;">{{ $value->date_approved ? Carbon\Carbon::parse($value->date_approved)->format('m/d/Y') : '-' }}</td>
                <td style="text-align:center;">{{ $value->auto_deduct ? 'Yes' :'No'}}</td>
                <td style="text-align:right;">{{ $value->install_period }}</td>
                <td style="text-align:right;">{{ $value->balance }}</td>
                <td style="text-align:right;">{{ $value->amount }}</td>
                <td style="text-align:right;">{{ $value->installment_amount }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>