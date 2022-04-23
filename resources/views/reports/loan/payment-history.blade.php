<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="8">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="8">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="8">Loan Payment History</td></tr>
    <tr>
        <td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="8">
            Name: {{ $data[0]->user->formal_name() }}  ({{ $data[0]->user->code }})
        </td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt;" colspan="8">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="8">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    
    {{--  --}}
    <tr>
        <td colspan="8"></td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="5" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Notes</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Pay Date</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Amount</td>
    </tr>

    @foreach($data as $value)
        <tr>
            <td colspan="5" style="text-align:left; word-wrap: break-word;">{{ $value->notes }}</td>
            <td colspan="2" style="text-align: center;">{{ $value->pay_date ? Carbon\Carbon::parse($value->pay_date)->format('m/d/Y') : '' }}</td>
            <td style="text-align:right;">{{ number_format($value->amount, 2, '.',',') }}</td>
        </tr>
    @endforeach
</table>