<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto px-6 md:px-32">

        {{-- header --}}
        <div class="ml-12 md:ml-0 mt-20 mb-6 space-x-4">
            <div class="flex items-center text-sm">
                <!-- Avatar with inset shadow -->
                <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block" >
                    <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $user->profile_photo_path) }}" alt="" loading="lazy" />
                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                </div>
                <div>
                    <p class="font-semibold text-2xl">{{ $user->informal_name() }}</p>
                    <p class="text-lg text-stone-600 ">
                        {{ $user->code }}
                    </p>
                </div>
            </div>

        </div>

        {{-- body --}}
        <div class=" w-full grid grid-cols-3 gap-4">

            <div class="col-span-3 md:col-span-2">
                {{-- personal information --}}
                <div class="py-4">
                    <div class="flex justify-between mb-2 border-b border-stone-200">
                        <p class="text-lg font-bold">
                            Personal Information
                        </p>
                        <a class="cursor-pointer text-blue-500 space-x-1" onclick="modalObject.openModal('modalPersonalInformation')">
                            <i class="fa-solid fa-xs fa-pen"></i>
                            <span class="text-xs font-semibold">edit</span>
                        </a>
                    </div>
                    <div class="space-y-2">
                        {{-- name --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Full Name
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->informal_name() }}
                                </p>
                            </div>
                        </div>
                        {{-- id --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    ID
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->code }}
                                </p>
                            </div>
                        </div>
                        {{-- email --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Email
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        {{-- phone --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Phone Number
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->phone_number }}
                                </p>
                            </div>
                        </div>
                        {{-- gender --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Gender
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ config('company.gender.'.$user->gender) }}
                                </p>
                            </div>
                        </div>
                        {{-- marital status --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Marital Status
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ config('company.marital_status.'.$user->marital_status) }}
                                </p>
                            </div>
                        </div>
                        {{-- birthdate --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Birth date
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ Carbon\Carbon::parse($user->birth_date)->format('dS M, Y') }}
                                </p>
                            </div>
                        </div>
                        {{-- address --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Address
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  --}}

                {{-- Employment details --}}
                <div class="py-4">
                    <div class="flex justify-between mb-2 border-b border-stone-200">
                        <p class="text-lg font-bold">
                            Employment Details
                        </p>
                        <a class="cursor-pointer text-blue-500 space-x-1" onclick="modalObject.openModal('modalEmploymentDetails')">
                            <i class="fa-solid fa-xs fa-pen"></i>
                            <span class="text-xs font-semibold">edit</span>
                        </a>
                    </div>
                    <div class="space-y-2">
                        {{-- employment status --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Employment Status
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ config('company.employment_status.'.$user->employment_status) }}
                                </p>
                            </div>
                        </div>
                        {{-- hired date --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Hired date
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ Carbon\Carbon::parse($user->hired_date)->format('dS M, Y') }}
                                </p>
                            </div>
                        </div>
                        {{-- active --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Active
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->is_active ? 'Yes':'No' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  --}}

                {{-- compensation --}}
                <div class="py-4">
                    <div class="flex justify-between mb-2 border-b border-stone-200">
                        <p class="text-lg font-bold">
                            Compensation
                        </p>
                        <a class="cursor-pointer text-blue-500 space-x-1" onclick="modalObject.openModal('modalCompensation')">
                            <i class="fa-solid fa-xs fa-pen"></i>
                            <span class="text-xs font-semibold">edit</span>
                        </a>
                    </div>
                    <div class="space-y-2">
                        {{-- department --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Department
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->latestDesignation() ? $user->latestDesignation()->department->department_name : ''  }}
                                </p>
                            </div>
                        </div>
                        {{-- designation / job title --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Job Title
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : 'N/A'  }}
                                </p>
                            </div>
                        </div>
                        {{-- daily rate --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Daily Rate
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    ₱{{ $user->latestDesignation() ? number_format($user->latestDesignation()->daily_rate, 2, '.', ',') : ''  }}
                                </p>
                            </div>
                        </div>
                        {{-- is paid holidays--}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Paid Holidays
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->is_paid_holidays ? 'Yes' :'No' }}
                                </p>
                            </div>
                        </div>
                        {{-- is tax exempted --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    Tax Exempted
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->is_tax_exempted ? 'Yes' :'No' }}
                                </p>
                            </div>
                        </div>
                        {{-- sss --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    SSS Number
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->sss_number }}
                                </p>
                            </div>
                        </div>
                        {{-- hdmf --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    HDMF Number
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->hdmf_number }}
                                </p>
                            </div>
                        </div>
                        {{-- phic --}}
                        <div class="grid grid-cols-3 gap-4">
                            {{-- labels --}}
                            <div class="col-span-1 items-center flex justify-end">
                                <p class="text-xs text-stone-500 font-semibold">
                                    PHIC Number
                                </p>
                            </div>
                            <div class="col-span-2 items-end flex justify-start">
                                <p class="text-sm text-stone-900 font-semibold">
                                    {{ $user->phic_number }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  --}}
            </div>

            {{-- right panel --}}
            <div class="col-span-3 md:col-span-1">

            </div>

        </div>
    </div>

    {{--  --}}
    @include('scripts.employee.profile-script')
    @include('modals.employee.profile-modal')
</div>
