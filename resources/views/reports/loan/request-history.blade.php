<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="14">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="14">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="14">Loan Request History</td></tr>
    <tr>
        <td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="14">
            Name: {{ $data[0]->user->formal_name() }}  ({{ $data[0]->user->code }})
        </td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt;" colspan="14">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="14">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    
    {{--  --}}
    <tr>
        <td colspan="14"></td>
    </tr>

    
    <tr>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Date</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Status</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Project</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align:center; word-wrap: break-word;">Install Period</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align:center; word-wrap: break-word;">Install Amount</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align:center;">Amount</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align:center;">Balance</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap: break-word;">Date Approved</td>
        <td rowspan="2" colspan="4" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Details</td>
    </tr>

    <tr>
        <td colspan="14"></td>
    </tr>
    @foreach($data as $loan)
    
        <tr>
            <td style="text-align: left;">{{ $loan->created_at ? Carbon\Carbon::parse($loan->created_at)->format('m/d/Y') : '-' }}</td>
            <td colspan="2" style="text-align: center;">
                @if($loan->status == 1)
                    Pending
                @elseif($loan->status == 2)
                    Approved
                @elseif($loan->status == 3)
                    Disapproved
                @endif
            </td>
            <td colspan="2" style="text-align:left;">{{ $loan->project ? $loan->project->name : 'N/A' }}</td>
            <td style="text-align:right;">{{ $loan->install_period }}</td>
            <td style="text-align:right;">{{ number_format($loan->installment_amount, 2, '.',',') }}</td>
            <td style="text-align:right;">{{ number_format($loan->amount, 2, '.',',') }}</td>
            <td style="text-align:right;">{{ number_format($loan->balance, 2, '.',',') }}</td>
            <td style="text-align: center;">{{ $loan->date_approved ? Carbon\Carbon::parse($loan->date_approved)->format('m/d/Y') : '-' }}</td>
            <td colspan="4" style="text-align:left;  word-wrap: break-word;">{{ $loan->details }}</td>
        </tr>
    @endforeach
</table>