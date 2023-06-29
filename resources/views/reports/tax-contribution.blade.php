<table width="100%" border="0" cellpadding="2" cellspacing="1" style="width:836pt; line-height:16pt; text-decoration:underline;">
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="12">{{ Helper::getCompanyInformation()->name }}</td></tr>
    <tr><td style="border:none; font-size:9pt; font-weight: normal; text-align: center;" colspan="12">{{ Helper::getCompanyInformation()->address }}</td></tr>
    <tr><td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="12">Contribution Report ({{ $data['frequency_id'] == 1 ? 'Semi-Monthly':'Weekly'}})</td></tr>
        <tr>
            <td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="12">
                Period Date: {{ Carbon\Carbon::parse($data['period_start'])->format('M d, Y') }} to {{ Carbon\Carbon::parse($data['period_end'])->format('M d, Y') }} 
            </td>
        </tr>
        <tr>
            <td style="border:none; font-size:12pt; font-weight: bold; text-align: center;" colspan="12">
                Payout Date: {{ Carbon\Carbon::parse($data['payout_date'])->format('M d, Y') }} 
            </td>
        </tr>
    <tr>
        <td style="border:none; font-size:12pt;" colspan="12">Rundate : {{ carbon\Carbon::now()->format('M d Y - h:i a') }}</td>
    </tr>
    <tr>
        <td style="border:none; font-size:12pt; text-transform:capitalize;" colspan="12">Run by : {{ Auth::user()->formal_name() }}</td>
    </tr>
    
    {{--  --}}
    <tr>
        <td colspan="12"></td>
    </tr>

    {{--  --}}
    <tr>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">EMPLOYEE INFORMATION</td>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">SSS</td>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">HDMF</td>
        <td colspan="3" style="border:1px solid #000; font-size:12pt; font-weight: bold; text-align: center;">PHIC</td>
        
    </tr>
    <tr >
        <td colspan="2" style="border:1px solid #000; font-weight: 500; text-align: center;">Name</td>
        <td colspan="1" style="border:1px solid #000; font-weight: 500; text-align: center;">ID</td>

        <td style="border:1px solid #000; font-weight: 500; text-align: center;">EE</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">ER</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">TOTAL</td>

        <td style="border:1px solid #000; font-weight: 500; text-align: center;">EE</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">ER</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">TOTAL</td>

        <td style="border:1px solid #000; font-weight: 500; text-align: center;">EE</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">ER</td>
        <td style="border:1px solid #000; font-weight: 500; text-align: center;">TOTAL</td>

    </tr>
    <tbody>
        <?php 
            $sss_ee = 0;
            $sss_er = 0;
            $hdmf_ee = 0;
            $hdmf_er = 0;
            $phic_ee = 0;
            $phic_er = 0;
        ?>
        @foreach($collection as $user)
            <tr>
                <td colspan="2" style="">{{ $user[0]->user->formal_name() }}</td>
                <td style="text-align: center;">{{ $user[0]->user->code }}</td>

                
                @foreach($user as $tax)
                    @php
                        $ee_share = strval(number_format($tax->employee_share, 2, '.', ',')) . "\u{00A0}";
                        $er_share = strval(number_format($tax->employee_share, 2, '.', ',')) . "\u{00A0}";
                        $total_share = strval(number_format(($tax->employee_share + $tax->employer_share), 2, '.', ',')) . "\u{00A0}"
                    @endphp
                    <td style="">{{ $ee_share }}</td>
                    <td style="">{{ $er_share }}</td>
                    <td style="">{{ $total_share }}</td>
                
                    <?php 
                        if($tax->tax_type == 1)
                        {
                            $sss_ee += $tax->employee_share;
                            $sss_er += $tax->employer_share;
                        }
                        if($tax->tax_type == 2)
                        {
                            $hdmf_ee += $tax->employee_share;
                            $hdmf_er += $tax->employer_share;
                        }
                        if($tax->tax_type == 3)
                        {
                            $phic_ee += $tax->employee_share;
                            $phic_er += $tax->employer_share;
                        }
                        
                    ?>
                @endforeach
            </tr>
            
        @endforeach
        <tr>
            <td colspan="3" style="text-align: right; border:1px solid #000; font-weight: 500;">TOTAL CONTRIBUTION</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format($sss_ee, 2, '.', ',') }}</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format($sss_er, 2, '.', ',') }}</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format(($sss_ee + $sss_er), 2, '.', ',') }}</td>

            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format($hdmf_ee, 2, '.', ',') }}</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format($hdmf_er, 2, '.', ',') }}</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format(($hdmf_ee + $hdmf_er), 2, '.', ',') }}</td>

            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format($phic_ee, 2, '.', ',') }}</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format($phic_er, 2, '.', ',') }}</td>
            <td style="text-align: right; border:1px solid #000; font-weight: 500;">{{ number_format(($phic_ee + $phic_er), 2, '.', ',') }}</td>
        </tr>
    </tbody>
</table>