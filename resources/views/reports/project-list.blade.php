<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="16">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="16">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="16">Project List Report</td></tr>
        
    <tr>
        <td style="border:none; font-size:12pt;" colspan="16">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="16">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    

    {{--  --}}
    <tr>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Project Name</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">ID</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Start Date</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">End Date</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Status</td>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Location</td>
        <td colspan="4" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: left;">Details</td>
    </tr>
    <tbody>
        @foreach($data as $project)
            <tr>
                <td colspan="2" rowspan="2" style="word-wrap: break-word;" valign="top">{{ $project->name }}</td>
                <td colspan="1" rowspan="2"  valign="top">{{ $project->code }}</td>
                <td colspan="2" rowspan="2" style="text-align: center;" valign="top">{{ $project->start_date ? Carbon\Carbon::parse($project->start_date)->format('M d, Y') : '' }}</td>
                <td colspan="2" rowspan="2" style="text-align: center;" valign="top">{{ $project->end_date ? Carbon\Carbon::parse($project->end_date)->format('M d, Y') : '' }}</td>
                <td colspan="2" rowspan="2" style="text-align: center;" valign="top">
                    @if($project->status == 1)
                        On-going
                    @elseif($project->status == 2)
                        Finished
                    @elseif($project->status == 3)
                        Upcoming
                    @endif
                </td>
                <td colspan="3" rowspan="2" style="word-wrap: break-word;" valign="top">{{ $project->location }}</td>
                <td colspan="4" rowspan="2" style="word-wrap: break-word;" valign="top">{{ $project->details }}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>