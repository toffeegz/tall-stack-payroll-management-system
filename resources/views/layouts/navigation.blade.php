    
    {{-- Desktop Sidebar --}}
    <div class="fixed">
        <aside class="z-20 hidden w-64 overflow-y-auto scrollbar-hide h-screen bg-white md:block flex-shrink-0 shadow-sm shadow-stone-200 border-r border-stone-100">
            <div class="pt-4 text-stone-500 flex flex-col h-full">
                
                <a href="#" class="ml-6 text-lg font-bold text-stone-800 flex-none">
                    {{ Helper::getCompanyInformation()->name }}
                </a>
                <div class="mt-6 flex-auto text-black text-sm" style="font-weight: 600;">
                    <ul class="space-y-1">
                        @if(Auth::user()->hasRole('administrator'))
                        {{-- dashboard --}}
                        <li class="px-4">
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'home') bg-stone-100 text-stone-500 @endif @endisset ">
                                <svg class="w-5 h-5" style=" fill:@isset($menu) @if($menu == 'dashboard') #78716c; @endif @endisset " xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" ><path d="M 23.951172 4 A 1.50015 1.50015 0 0 0 23.072266 4.3222656 L 8.859375 15.519531 C 7.0554772 16.941163 6 19.113506 6 21.410156 L 6 40.5 C 6 41.863594 7.1364058 43 8.5 43 L 18.5 43 C 19.863594 43 21 41.863594 21 40.5 L 21 30.5 C 21 30.204955 21.204955 30 21.5 30 L 26.5 30 C 26.795045 30 27 30.204955 27 30.5 L 27 40.5 C 27 41.863594 28.136406 43 29.5 43 L 39.5 43 C 40.863594 43 42 41.863594 42 40.5 L 42 21.410156 C 42 19.113506 40.944523 16.941163 39.140625 15.519531 L 24.927734 4.3222656 A 1.50015 1.50015 0 0 0 23.951172 4 z M 24 7.4101562 L 37.285156 17.876953 C 38.369258 18.731322 39 20.030807 39 21.410156 L 39 40 L 30 40 L 30 30.5 C 30 28.585045 28.414955 27 26.5 27 L 21.5 27 C 19.585045 27 18 28.585045 18 30.5 L 18 40 L 9 40 L 9 21.410156 C 9 20.030807 9.6307412 18.731322 10.714844 17.876953 L 24 7.4101562 z"></path></svg>
                                <span class="ml-6">Dashboard</span>
                            </a>
                        </li>
                        @endif
                        {{-- employee --}}
                        @if(Auth::user()->hasRole('administrator'))
                            <li class="px-4">
                                <a href="{{ route('employee') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'employee') bg-stone-100 text-stone-500 @endif @endisset ">
                                    <svg class="w-5 h-5" style=" fill:@isset($menu) @if($menu == 'employee') #78716c; @endif @endisset " xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 16 16"><path d="M 8 2 C 6.347656 2 5 3.347656 5 5 C 5 6.652344 6.347656 8 8 8 C 9.652344 8 11 6.652344 11 5 C 11 3.347656 9.652344 2 8 2 Z M 8 8 C 5.246094 8 3 10.246094 3 13 L 4 13 C 4 10.785156 5.785156 9 8 9 C 10.214844 9 12 10.785156 12 13 L 13 13 C 13 10.246094 10.753906 8 8 8 Z M 8 3 C 9.109375 3 10 3.890625 10 5 C 10 6.109375 9.109375 7 8 7 C 6.890625 7 6 6.109375 6 5 C 6 3.890625 6.890625 3 8 3 Z"></path></svg>
                                    <span class="ml-6">Employee</span>
                                </a>
                            </li>
                        @endif
                        {{-- project --}}
                        @if(Auth::user()->hasRole('administrator'))
                            <li class="px-4">
                                <a href="{{ route('project') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'project') bg-stone-100 text-stone-500 @endif @endisset " >
                                    <svg class="w-5 h-5" style=" fill:@isset($menu) @if($menu == 'project') #78716c; @endif @endisset " xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"viewBox="0 0 48 48"><path d="M 8.5 8 C 6.0324991 8 4 10.032499 4 12.5 L 4 35.5 C 4 37.967501 6.0324991 40 8.5 40 L 39.5 40 C 41.967501 40 44 37.967501 44 35.5 L 44 17.5 C 44 15.032499 41.967501 13 39.5 13 L 24.042969 13 L 19.572266 9.2753906 C 18.584055 8.4521105 17.339162 8 16.052734 8 L 8.5 8 z M 8.5 11 L 16.052734 11 C 16.638307 11 17.202555 11.205358 17.652344 11.580078 L 21.15625 14.5 L 17.652344 17.419922 C 17.202555 17.794642 16.638307 18 16.052734 18 L 7 18 L 7 12.5 C 7 11.653501 7.6535009 11 8.5 11 z M 24.042969 16 L 39.5 16 C 40.346499 16 41 16.653501 41 17.5 L 41 35.5 C 41 36.346499 40.346499 37 39.5 37 L 8.5 37 C 7.6535009 37 7 36.346499 7 35.5 L 7 21 L 16.052734 21 C 17.339162 21 18.584055 20.547889 19.572266 19.724609 L 24.042969 16 z"></path></svg>
                                    <span class="ml-6">Project</span>
                                </a>
                            </li>
                        @endif
                        {{-- attendance --}}
                        <li class="px-4" x-data="{ leave_attendance: @isset($menu) @if($menu == 'attendance' || $menu == 'leave') true @else false @endif @endisset }">
                            <button class="px-6 py-3 flex justify-between items-center w-full transition-colors duration-150 font-semibold hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'attendance'  || $menu == 'leave') bg-stone-100 text-stone-500 @endif @endisset "
                                @click="leave_attendance = !leave_attendance"
                                aria-haspopup="true" >
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5" style=" fill:@isset($menu) @if($menu == 'attendance') #78716c; @endif @endisset " xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#000000;"><path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 23.476562 11.978516 A 1.50015 1.50015 0 0 0 22 13.5 L 22 25.5 A 1.50015 1.50015 0 0 0 23.5 27 L 31.5 27 A 1.50015 1.50015 0 1 0 31.5 24 L 25 24 L 25 13.5 A 1.50015 1.50015 0 0 0 23.476562 11.978516 z"></path></svg>
                                    <span class="ml-6">Attendance</span>
                                </span>
                                <svg
                                    class="w-4 h-4"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    >
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" ></path>
                                </svg>
                            </button>
                            <template x-if="leave_attendance">
                                <ul
                                    x-transition:enter="transition-all ease-in-out duration-300"
                                    x-transition:enter-start="opacity-25 max-h-0"
                                    x-transition:enter-end="opacity-100 max-h-xl"
                                    x-transition:leave="transition-all ease-in-out duration-300"
                                    x-transition:leave-start="opacity-100 max-h-xl"
                                    x-transition:leave-end="opacity-0 max-h-0"
                                    class="p-2 space-y-2 overflow-hidden text-black " 
                                    aria-label="submenu" >

                                    <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'attendance') text-stone-500 @endif @endisset" >
                                        <a href="{{ route('attendance') }}">
                                            <span class="ml-3">
                                                Attendance
                                            </span>
                                        </a>
                                    </li>
                                    <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'leave') text-stone-500 @endif @endisset" >
                                        <a href="{{ route('leave') }}">
                                            <span class="ml-3">
                                                Leave
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </template>
                        </li>
                        {{-- loans --}}
                        @if(Auth::user()->hasRole('administrator'))
                            <li class="px-4" x-data="{ loan: @isset($menu) @if($menu == 'loan' || $menu == 'grand-loan' || $menu == 'loan-installment') true @else false @endif @endisset }">
                                <button class="px-6 py-3 flex justify-between items-center w-full transition-colors duration-150 font-semibold hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'loan'  || $menu == 'grand-loan' || $menu == 'loan-installment') bg-stone-100 text-stone-500 @endif @endisset "
                                    @click="loan = !loan"
                                    aria-haspopup="true" >
                                    <span class="inline-flex items-center">
                                        <svg class="w-5 h-5" style=" color:@isset($menu) @if($menu == 'loan' || $menu == 'grand-loan' || $menu == 'loan-installment') #78716c; @endif @endisset xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                            <path d="M12 6v2m0 8v2"></path>
                                        </svg>
                                        <span class="ml-6">Loans</span>
                                    </span>
                                    <svg
                                        class="w-4 h-4"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        >
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" ></path>
                                    </svg>
                                </button>
                                <template x-if="loan">
                                    <ul
                                        x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="p-2 space-y-2 overflow-hidden text-black " 
                                        aria-label="submenu" >

                                        <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'grand-loan') text-stone-500 @endif @endisset" >
                                            <a href="{{ route('loan.grand') }}">
                                                <span class="ml-3">
                                                    Grand Loan
                                                </span>
                                            </a>
                                        </li>
                                        <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'loan-installment') text-stone-500 @endif @endisset" >
                                            <a href="{{ route('loan.installment') }}">
                                                <span class="ml-3">
                                                     Installments
                                                </span>
                                            </a>
                                        </li>
                                        <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'loan') text-stone-500 @endif @endisset" >
                                            <a href="{{ route('loan') }}">
                                                <span class="ml-3">
                                                    My Loans
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </li>
                        @else 
                            <li class="px-4">
                                <a href="{{ route('loan') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'loan') bg-stone-100 text-stone-500 @endif @endisset ">
                                    <svg class="w-5 h-5" style=" color:@isset($menu) @if($menu == 'loan') #78716c; @endif @endisset xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                        <path d="M12 6v2m0 8v2"></path>
                                    </svg>
                                    <span class="ml-6">Loans</span>
                                </a>
                            </li>
                        @endif
                        {{-- payroll --}}
                        @if(Auth::user()->hasRole('administrator'))
                            <li class="px-4" x-data="{ payroll: @isset($menu) @if($menu == 'payroll' || $menu == 'payroll settings' || $menu == 'payslip') true @else false @endif @endisset }">
                                <button class="px-6 py-3 flex justify-between items-center w-full transition-colors duration-150 font-semibold hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'payroll'  || $menu == 'payroll settings' || $menu == 'payslip') bg-stone-100 text-stone-500 @endif @endisset "
                                    @click="payroll = !payroll"
                                    aria-haspopup="true" >
                                    <span class="inline-flex items-center">
                                        <svg class="w-5 h-5" style=" color:@isset($menu) @if($menu == 'payroll' || $menu == 'payroll settings' || $menu == 'payslip') #78716c; @endif @endisset xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                            <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                            <path d="M12 17v1m0 -8v1"></path>
                                        </svg>
                                        <span class="ml-6">Payroll</span>
                                    </span>
                                    <svg
                                        class="w-4 h-4"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        >
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" ></path>
                                    </svg>
                                </button>
                                <template x-if="payroll">
                                    <ul
                                        x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="p-2 space-y-2 overflow-hidden text-black " 
                                        aria-label="submenu" >

                                        <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'payroll') text-stone-500 @endif @endisset" >
                                            <a href="{{ route('payroll') }}">
                                                <span class="ml-3">
                                                    Run Payroll
                                                </span>
                                            </a>
                                        </li>
                                        <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'payroll settings') text-stone-500 @endif @endisset" >
                                            <a >
                                                <span class="ml-3">
                                                    Settings
                                                </span>
                                            </a>
                                        </li>
                                        <li class="px-12 py-1 transition-colors duration-150 hover:text-stone-900 @isset($menu) @if($menu == 'payslip') text-stone-500 @endif @endisset" >
                                            <a href="{{ route('payslip') }}">
                                                <span class="ml-3">
                                                    My Payslip
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </li>
                        @else 
                            <li class="px-4">
                                <a href="{{ route('payslip') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'payslip') bg-stone-100 text-stone-500 @endif @endisset ">
                                    <svg class="w-5 h-5" style=" " xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                        <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                        <path d="M12 17v1m0 -8v1"></path>
                                    </svg>
                                    <span class="ml-6">My Payslip</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->hasRole('administrator'))
                        {{-- report --}}
                        <li class="px-4">
                            <a href="{{ route('reports') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'report') bg-stone-100 text-stone-500 @endif @endisset " >
                                <svg class="w-5 h-5" style=" fill:@isset($menu) @if($menu == 'report') #78716c; @endif @endisset "xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"viewBox="0 0 48 48"><path d="M 12.5 4 C 10.032499 4 8 6.0324991 8 8.5 L 8 39.5 C 8 41.967501 10.032499 44 12.5 44 L 35.5 44 C 37.967501 44 40 41.967501 40 39.5 L 40 18.5 A 1.50015 1.50015 0 0 0 39.560547 17.439453 L 39.544922 17.423828 L 26.560547 4.4394531 A 1.50015 1.50015 0 0 0 25.5 4 L 12.5 4 z M 12.5 7 L 24 7 L 24 15.5 C 24 17.967501 26.032499 20 28.5 20 L 37 20 L 37 39.5 C 37 40.346499 36.346499 41 35.5 41 L 12.5 41 C 11.653501 41 11 40.346499 11 39.5 L 11 8.5 C 11 7.6535009 11.653501 7 12.5 7 z M 27 9.1210938 L 34.878906 17 L 28.5 17 C 27.653501 17 27 16.346499 27 15.5 L 27 9.1210938 z M 17.5 25 A 1.50015 1.50015 0 1 0 17.5 28 L 30.5 28 A 1.50015 1.50015 0 1 0 30.5 25 L 17.5 25 z M 17.5 32 A 1.50015 1.50015 0 1 0 17.5 35 L 26.5 35 A 1.50015 1.50015 0 1 0 26.5 32 L 17.5 32 z"></path></svg>
                                <span class="ml-6">Report</span>
                            </a>
                        </li>
                        @endif
                        {{-- settings --}}
                        @if(Auth::user()->hasRole('administrator'))
                            <li class="px-4">
                                <a href="{{ route('settings') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'settings') bg-stone-100 text-stone-500 @endif @endisset " >
                                    <svg class="w-5 h-5" style=" fill:@isset($menu) @if($menu == 'settings') #78716c; @endif @endisset " xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48"><path d="M 24 4 C 22.423103 4 20.902664 4.1994284 19.451172 4.5371094 A 1.50015 1.50015 0 0 0 18.300781 5.8359375 L 17.982422 8.7382812 C 17.878304 9.6893592 17.328913 10.530853 16.5 11.009766 C 15.672739 11.487724 14.66862 11.540667 13.792969 11.15625 L 13.791016 11.15625 L 11.125 9.9824219 A 1.50015 1.50015 0 0 0 9.4257812 10.330078 C 7.3532865 12.539588 5.7626807 15.215064 4.859375 18.201172 A 1.50015 1.50015 0 0 0 5.4082031 19.845703 L 7.7734375 21.580078 C 8.5457929 22.147918 9 23.042801 9 24 C 9 24.95771 8.5458041 25.853342 7.7734375 26.419922 L 5.4082031 28.152344 A 1.50015 1.50015 0 0 0 4.859375 29.796875 C 5.7625845 32.782665 7.3519262 35.460112 9.4257812 37.669922 A 1.50015 1.50015 0 0 0 11.125 38.015625 L 13.791016 36.841797 C 14.667094 36.456509 15.672169 36.511947 16.5 36.990234 C 17.328913 37.469147 17.878304 38.310641 17.982422 39.261719 L 18.300781 42.164062 A 1.50015 1.50015 0 0 0 19.449219 43.460938 C 20.901371 43.799844 22.423103 44 24 44 C 25.576897 44 27.097336 43.800572 28.548828 43.462891 A 1.50015 1.50015 0 0 0 29.699219 42.164062 L 30.017578 39.261719 C 30.121696 38.310641 30.671087 37.469147 31.5 36.990234 C 32.327261 36.512276 33.33138 36.45738 34.207031 36.841797 L 36.875 38.015625 A 1.50015 1.50015 0 0 0 38.574219 37.669922 C 40.646713 35.460412 42.237319 32.782983 43.140625 29.796875 A 1.50015 1.50015 0 0 0 42.591797 28.152344 L 40.226562 26.419922 C 39.454197 25.853342 39 24.95771 39 24 C 39 23.04229 39.454197 22.146658 40.226562 21.580078 L 42.591797 19.847656 A 1.50015 1.50015 0 0 0 43.140625 18.203125 C 42.237319 15.217017 40.646713 12.539588 38.574219 10.330078 A 1.50015 1.50015 0 0 0 36.875 9.984375 L 34.207031 11.158203 C 33.33138 11.54262 32.327261 11.487724 31.5 11.009766 C 30.671087 10.530853 30.121696 9.6893592 30.017578 8.7382812 L 29.699219 5.8359375 A 1.50015 1.50015 0 0 0 28.550781 4.5390625 C 27.098629 4.2001555 25.576897 4 24 4 z M 24 7 C 24.974302 7 25.90992 7.1748796 26.847656 7.3398438 L 27.035156 9.0644531 C 27.243038 10.963375 28.346913 12.652335 30 13.607422 C 31.654169 14.563134 33.668094 14.673009 35.416016 13.904297 L 37.001953 13.207031 C 38.219788 14.669402 39.183985 16.321182 39.857422 18.130859 L 38.451172 19.162109 C 36.911538 20.291529 36 22.08971 36 24 C 36 25.91029 36.911538 27.708471 38.451172 28.837891 L 39.857422 29.869141 C 39.183985 31.678818 38.219788 33.330598 37.001953 34.792969 L 35.416016 34.095703 C 33.668094 33.326991 31.654169 33.436866 30 34.392578 C 28.346913 35.347665 27.243038 37.036625 27.035156 38.935547 L 26.847656 40.660156 C 25.910002 40.82466 24.973817 41 24 41 C 23.025698 41 22.09008 40.82512 21.152344 40.660156 L 20.964844 38.935547 C 20.756962 37.036625 19.653087 35.347665 18 34.392578 C 16.345831 33.436866 14.331906 33.326991 12.583984 34.095703 L 10.998047 34.792969 C 9.7799772 33.330806 8.8159425 31.678964 8.1425781 29.869141 L 9.5488281 28.837891 C 11.088462 27.708471 12 25.91029 12 24 C 12 22.08971 11.087719 20.290363 9.5488281 19.160156 L 8.1425781 18.128906 C 8.8163325 16.318532 9.7814501 14.667839 11 13.205078 L 12.583984 13.902344 C 14.331906 14.671056 16.345831 14.563134 18 13.607422 C 19.653087 12.652335 20.756962 10.963375 20.964844 9.0644531 L 21.152344 7.3398438 C 22.089998 7.1753403 23.026183 7 24 7 z M 24 16 C 19.599487 16 16 19.59949 16 24 C 16 28.40051 19.599487 32 24 32 C 28.400513 32 32 28.40051 32 24 C 32 19.59949 28.400513 16 24 16 z M 24 19 C 26.779194 19 29 21.220808 29 24 C 29 26.779192 26.779194 29 24 29 C 21.220806 29 19 26.779192 19 24 C 19 21.220808 21.220806 19 24 19 z"></path></svg>
                                    <span class="ml-6">Settings</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- PROFILE --}}
                <div x-cloak x-data="{ profileDropdown: false }" class="flex flex-col items-center border border-stone-200 rounded-t-2xl">
                    {{-- profile button --}}
                    <button x-on:click="profileDropdown = !profileDropdown" class="px-4 py-4 flex justify-between w-full space-x-2 focus:outline-none border-0 ">
                        <div class="flex">
                            <div class="flex justify-center items-center">
                                <div class="flex items-center justify-center bg-white rounded-xl border border-stone-300 p-1 focus:outline-none focus:shadow-outline-stone">
                                    <img src="{{ asset('storage/img/users/'. Auth::user()->profile_photo_path) }}" 
                                        class="h-10 w-10 rounded-lg object-cover"
                                    />
                                </div>
                            </div>
                            <div class="flex items-center h-12">
                                <div class="flex flex-col">
                                    <div class="text-center text-sm font-bold leading-5 text-stone-900">
                                        {{ Auth::user()->informal_name() }}
                                    </div>
                                    <div class="text-center text-sm ml-2 font-medium leading-5 text-stone-500">
                                        {{ Auth::user()->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center m-1 h-10 fa-sm text-stone-400">
                            <i class="fa-solid fa-angles-down"></i>
                        </div>
                    </button>
                    {{-- DROPDOWN --}}
                    <div x-show="profileDropdown" class="w-full text-black text-sm pb-4" style="font-weight: 600;">
                        <ul class="space-y-1">
                            {{-- dashboard --}}
                            <li class="px-4">
                                <a href="{{ route('profile') }}" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'profile') bg-stone-100 text-stone-500 @endif @endisset ">
                                    <i class="@isset($menu) {{ $menu == 'profile' ? 'text-stone-500' : 'text-stone-900' }} @endisset fa-solid fa-user"></i>
                                    <span class="ml-6">My Profile</span>
                                </a>
                            </li>
                            <li class="px-4">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="px-6 py-3 inline-flex items-center w-full transition-colors duration-150 hover:text-stone-500 rounded-full @isset($menu) @if($menu == 'home') bg-stone-100 text-stone-500 @endif @endisset ">
                                        <i class=" fa-solid fa-arrow-right-from-bracket "></i>
                                        <span class="ml-6">Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </aside>
    </div>
    {{-- Mobile Sidebar --}}
    <div x-cloak class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>
    <aside x-cloak class="fixed inset-y-0 z-20 flex-shrink-0 w-64 overflow-y-auto bg-white md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -transtone-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -transtone-x-20"
        @click.away="closeSideMenu"
        @keydown.escape="closeSideMenu" >

        <div class="py-4 text-stone-500 flex flex-col h-full">
            <a href="#" class="ml-6 text-lg font-bold text-stone-800 flex-none">
                Windmill
            </a>
            <div class="mt-6 flex-auto">
                <ul>
                    <li class="relative px-6 py-3">
                        <span class="absolute inset-y-0 left-0 w-1 bg-stone-900 rounded-tr-md rounded-br-md" aria-hidden="true"></span>
                        <a class="inline-flex items-center w-full text-sm font-semibold text-stone-800 transition-colors duration-150 hover:text-stone-800 " href="index.html">
                            <svg class="w-5 h-5"
                                aria-hidden="true"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <a href="forms.html" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-stone-800 dark:hover:text-stone-100">
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                >
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="ml-4">Forms</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <a href="forms.html" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-stone-800 dark:hover:text-stone-100">
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                >
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="ml-4">Forms</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <a href="forms.html" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-stone-800 dark:hover:text-stone-100">
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                >
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="ml-4">Forms</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-stone-800 dark:hover:text-stone-100"
                            @click="togglePagesMenu"
                            aria-haspopup="true" >
                            <span class="inline-flex items-center">
                                <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                </svg>
                                <span class="ml-4">Pages</span>
                            </span>
                            <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                >
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" ></path>
                            </svg>
                        </button>
                        <template x-if="isPagesMenuOpen">
                            <ul
                                x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                x-transition:leave="transition-all ease-in-out duration-300"
                                x-transition:leave-start="opacity-100 max-h-xl"
                                x-transition:leave-end="opacity-0 max-h-0"
                                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-stone-500 rounded-md shadow-inner bg-stone-50 dark:text-stone-400 dark:bg-stone-900"
                                aria-label="submenu" >

                                <li class="px-2 py-1 transition-colors duration-150 hover:text-stone-800 dark:hover:text-stone-100" >
                                        <a class="w-full" href="pages/login.html">Login</a>
                                </li>
                            </ul>
                        </template>
                    </li>
                    
                </ul>
            </div>
            <div class="flex justify-center items-center">
                <div class="flex flex-col space-y-2">
                    <div class="flex justify-center items-center">
                        <button class="flex items-center justify-center bg-white rounded-xl border border-stone-300 p-1 focus:outline-none focus:shadow-outline-stone">
                            <img src="{{ asset('storage/img/users/'. Auth::user()->profile_photo_path) }}" 
                                class="h-10 w-10 rounded-lg object-cover"
                            />
                        </button>
                    </div>
                    <div class="text-center text-sm font-medium leading-5 text-stone-500">
                        {{ Auth::user()->informal_name() }}
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile hamburger -->
    <div class="fixed top-0 left-0 p-4">
        <button class="p-2 rounded-xl md:hidden focus:outline-none text-white bg-stone-900"
            @click="toggleSideMenu"
            aria-label="Menu">
            <svg class="w-5 h-5"  style=" fill:#fff;" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48"><path d="M 5.5 9 A 1.50015 1.50015 0 1 0 5.5 12 L 42.5 12 A 1.50015 1.50015 0 1 0 42.5 9 L 5.5 9 z M 5.5 22.5 A 1.50015 1.50015 0 1 0 5.5 25.5 L 42.5 25.5 A 1.50015 1.50015 0 1 0 42.5 22.5 L 5.5 22.5 z M 5.5 36 A 1.50015 1.50015 0 1 0 5.5 39 L 42.5 39 A 1.50015 1.50015 0 1 0 42.5 36 L 5.5 36 z"></path></svg>
        </button>
    </div>