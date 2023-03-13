<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="20">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="20">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="20">Employee Export</td></tr>
        
    <tr>
        <td style="border:none; font-size:12pt;" colspan="20">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="20">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">ID</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Last Name</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">First Name</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">M.I.</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Email</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Phone</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">Gender</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">Marital Status</td>
        <td colspan="`" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">Dependent</td>
        <td colspan="1" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">Nationality</td>
        {{-- <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">Address</td> --}}
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">Employment Status</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">SSS Number</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">HDMF Number</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">PHIC Number</td>
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">TIN Number</td> 
        <td colspan="2" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center; word-wrap:break-word">Hire Date</td> 
    </tr>
    <tbody>
        @foreach($data as $user)
            <tr>
                <td colspan="1">{{ $user->code }}</td>
                <td colspan="2">{{ $user->last_name }}</td>
                <td colspan="2">{{ $user->first_name }}</td>
                <td colspan="1">{{ $user->middle_name ? $user->middle_name[0] : '' }}</td>
                <td colspan="2">{{ $user->email }}</td>
                <td colspan="2">{{ $user->phone_number }}</td>
                <td colspan="1">{{ config('company.gender.'.$user->gender) }}</td>
                <td colspan="1">{{ config('company.marital_status.'.$user->marital_status) }}</td>
                <td colspan="1">{{ $user->number_dependent }}</td>
                <td colspan="1">{{ $user->nationality }}</td>
                {{-- <td colspan="2">{{ $user->address }}</td> --}}
                <td colspan="2">{{ config('company.employment_status.'.$user->employment_status) }}</td>
                <td colspan="2">{{ $user->sss_number }}</td>
                <td colspan="2">{{ $user->pagibig_number }}</td>
                <td colspan="2">{{ $user->phic_number }}</td>
                <td colspan="2">{{ $user->tin_number }}</td>
                <td colspan="2">{{ Carbon\Carbon::parse($user->hire_date)->format('M d, Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>