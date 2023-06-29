<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="11">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="11">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="11">Loan Installment Export</td></tr>
    
    <tr>
        <td style="border:none; font-size:12pt;" colspan="11">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="11">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    
    {{--  --}}
    <tr>
        <td colspan="11"></td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Employee Information</td>
        <td colspan="5" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Notes</td>
        <td colspan="2" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Pay Date</td>
        <td colspan="1" rowspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Amount</td>
    </tr>
    <tr >
        <td colspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Name</td>
        <td colspan="1" style="border:1px solid #000; font-weight: 500; text-align: center;">ID</td>
    </tr>

    @foreach($data as $value)
        <tr>
            <td colspan="2">{{ $value->user->formal_name() }}</td>
            <td>{{ $value->user->code }}</td>
            <td colspan="5" style="text-align:left; word-wrap: break-word;">{{ $value->notes }}</td>
            <td colspan="2" style="text-align: center;">{{ $value->pay_date ? Carbon\Carbon::parse($value->pay_date)->format('m/d/Y') : '-' }}</td>
            <td style="text-align:right;">{{ $value->amount }}</td>
        </tr>
    @endforeach
</table>