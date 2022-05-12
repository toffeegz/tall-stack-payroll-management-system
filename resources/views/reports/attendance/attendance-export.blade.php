<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="14">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="14">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="14">Attendance Export</td></tr>
        
    <tr>
        <td style="border:none; font-size:12pt;" colspan="14">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="14">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Employee ID</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Full Name</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Date</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Time In</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Time Out</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Status</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: right;">RH</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: right;">OT</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: right;">ND</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: right;">LATE</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: right;">UD</td>
    </tr>
    <tbody>
        @foreach($data as $value)
            <tr>
                <td colspan="2" style="text-align:center;">{{ $value->user->code }}</td>
                <td colspan="2">{{ $value->user->formal_name() }}</td>
                <td colspan="2" style="text-align:center;">{{ Carbon\Carbon::parse($value->date)->format('M d, Y') }}</td>
                <td colspan="1">{{ Carbon\Carbon::parse($value->time_in)->format('h:i a') }}</td>
                <td colspan="1">{{ Carbon\Carbon::parse($value->time_out)->format('h:i a') }}</td>
                <td colspan="1">
                    @switch($value->status)
                        @case(1)
                            Present
                            @break
                        @case(2)
                            Late
                            @break
                        @case(3)
                            No Sched
                            @break
                        @case(4)
                            Pending
                            @break
                        @case(5)
                            Inc
                            @break
                    @endswitch
                </td>
                <td colspan="1">
                    {{ $value->regular }}
                </td>
                <td colspan="1">
                    {{ $value->overtime }}
                </td>
                <td colspan="1">
                    {{ $value->night_differential }}
                </td>
                <td colspan="1">
                    {{ $value->late }}
                </td>
                <td colspan="1">
                    {{ $value->undertime }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>