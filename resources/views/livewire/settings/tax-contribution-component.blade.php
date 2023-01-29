<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{--  --}}
    {{-- SSS --}}
    <div>
        <h2 class="my-4 font-bold text-stone-900">
            SSS Contribution Model
        </h2>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                        
                        <th class="px-4 py-3">Min</th>
                        <th class="px-4 py-3">Max</th>
                        <th class="px-4 py-3">MSC</th>
                        <th class="px-4 py-3">ER</th>
                        <th class="px-4 py-3">EE</th>
                        <th class="px-4 py-3">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y "  >
                        @foreach($sss_contributions->sss_contributions as $sss_contribution)
                            <tr class="text-stone-700 ">
                                <td class="px-4 py-2 text-xs">
                                    {{ $sss_contribution->compensation_minimum }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $sss_contribution->compensation_maximum }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $sss_contribution->monthly_salary_credit }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $sss_contribution->monthly_salary_credit * ($sss_contributions->er_share/100) + $sss_contribution->ec_contribution }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $sss_contribution->monthly_salary_credit * ($sss_contributions->ee_share/100) }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $sss_contribution->monthly_salary_credit * ($sss_contributions->ee_share/100) + ($sss_contribution->monthly_salary_credit * ($sss_contributions->er_share/100) + $sss_contribution->ec_contribution) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <h2 class="my-4 font-bold text-stone-900">
            HDMF Contribution Rates
        </h2>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                        <th class="px-4 py-3">EE Share</th>
                        <th class="px-4 py-3">ER Share</th>
                        <th class="px-4 py-3">MSC Min</th>
                        <th class="px-4 py-3">MSC Max</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y "  >
                        @foreach($hdmf_contributions as $hdmf_contribution)
                            <tr class="text-stone-700 ">
                                <td class="px-4 py-2 text-xs">
                                    {{ $hdmf_contribution->ee_share }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $hdmf_contribution->er_share }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $hdmf_contribution->msc_min }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $hdmf_contribution->msc_max }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <h2 class="my-4 font-bold text-stone-900">
            PHIC Contribution Rates
        </h2>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                        <th class="px-4 py-3">Premium Rate</th>
                        <th class="px-4 py-3">MBS Min</th>
                        <th class="px-4 py-3">MBS Max</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y "  >
                        @foreach($phic_contributions as $phic_contribution)
                            <tr class="text-stone-700 ">
                                <td class="px-4 py-2 text-xs">
                                    {{ $phic_contribution->premium_rate }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $phic_contribution->mbs_min }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ $phic_contribution->mbs_max }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
