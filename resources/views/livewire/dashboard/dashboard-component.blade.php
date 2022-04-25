<div>
    {{--  --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700 ">
                Dashboard
            </h2>
            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">

                <!-- Card -->
                <div class="flex items-center p-4 bg-orange-50 rounded-2xl shadow-xs " >
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full " >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-stone-600 " >
                            Total Employees
                        </p>
                        <p class="text-lg font-semibold text-stone-700 "  >
                            {{ $users_count }}
                        </p>
                    </div>
                </div>

                <!-- Card -->
                <div class="flex items-center p-4 bg-green-50 rounded-2xl shadow-xs " >
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full " >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-stone-600 " >
                            Projects
                        </p>
                        <p class="text-lg font-semibold text-stone-700 "  >
                            {{ $projects_count }}
                        </p>
                    </div>
                </div>

                <!-- Card -->
                <div class="flex items-center p-4 bg-teal-50 rounded-2xl shadow-xs " >
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full " >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-stone-600 " >
                            Loan Balance
                        </p>
                        <p class="text-lg font-semibold text-stone-700 "  >
                            ₱ {{ $loan_balance }}
                        </p>
                    </div>
                </div>

                <!-- Card -->
                <div class="flex items-center p-4 bg-stone-50 rounded-2xl shadow-xs " >
                    <div class="p-3 mr-4 text-stone-500 bg-stone-100 rounded-full " >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-stone-600 " >
                            On-Leave
                        </p>
                        <p class="text-lg font-semibold text-stone-700 "  >
                            {{ $on_leave_users_count }}
                        </p>
                    </div>
                </div>

            </div>


            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-black">
                    Things to review
                </h2>
                {{-- time in and out --}}
                <a href="{{ route('attendance') }}" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                    <div class="flex flex-row space-x-4">
                        <div class="flex items-center bg-red-100 rounded-md p-2">
                            <svg class="w-6 h-6" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#ef4444;" xmlns="http://www.w3.org/2000/svg"><path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 23.476562 11.978516 A 1.50015 1.50015 0 0 0 22 13.5 L 22 25.5 A 1.50015 1.50015 0 0 0 23.5 27 L 31.5 27 A 1.50015 1.50015 0 1 0 31.5 24 L 25 24 L 25 13.5 A 1.50015 1.50015 0 0 0 23.476562 11.978516 z"></path></svg>
                        </div>
                        <div>
                            <div class="font-bold text-base">Review and approve attendance requests</div>
                            <div class="text-stone-500 text-sm font-light">You have {{ $attendance_requests_count }} attendance requests to review</div>
                        </div>
                    </div>
                    <span>&RightArrow;</span>
                </a>
                {{-- cancel loan deduction --}}
                <a href="{{ route('loan.grand') }}" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                    <div class="flex flex-row space-x-4">
                        <div class="flex items-center bg-blue-100 rounded-md p-2">
                            <svg class="w-6 h-6" style=" color:#3b82f6;" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                <path d="M12 6v2m0 8v2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-base">Review and approve loan requests</div>
                            <div class="text-stone-500 text-sm font-light">You have {{ $loan_requests_count }} loan requests to review</div>
                        </div>
                    </div>
                    <span>&RightArrow;</span>
                </a>
            </div>


        </div>
    </div>

</div>
