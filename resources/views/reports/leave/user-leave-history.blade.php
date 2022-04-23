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
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Start Date</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">End Date</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Duration</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Day Type</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Leave Type</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Status</td>
        <td rowspan="2" colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Created At</td>
        <td rowspan="2" colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Reason</td>
    </tr>

    <tr>
        <td colspan="14"></td>
    </tr>
    @foreach($data as $value)
    
        <tr>
            <td colspan="1" style="text-align: left;">{{ $value->start_date ? Carbon\Carbon::parse($value->start_date)->format('m/d/Y') : '' }}</td>
            <td colspan="1" style="text-align: left;">{{ $value->end_date ? Carbon\Carbon::parse($value->end_date)->format('m/d/Y') : '' }}</td>
            <td colspan="1" style="text-align:center;">{{ $value->hours_duration }}</td>
            <td colspan="2" style="text-align:left;">{{ config('company.leave_type.'.$value->type_id) }}</td>
            <td colspan="2" style="text-align:left;">{{ $value->leaveType->name }}</td>
            <td colspan="1" style="text-align: center;">
                @if($value->status == 1)
                    Pending
                @elseif($value->status == 2)
                    Approved
                @elseif($value->status == 3)
                    Disapproved
                @endif
            </td>
            <td colspan="1" style="text-align:left;">{{ $value->created_at ? Carbon\Carbon::parse($value->created_at)->format('m/d/Y') : '' }}</td>
            <td colspan="3" style="text-align:right;">{{ $value->reason }}</td>
        </tr>
    @endforeach
</table>