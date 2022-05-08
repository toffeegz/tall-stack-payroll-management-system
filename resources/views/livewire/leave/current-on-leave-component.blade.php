<div>
    {{-- The whole world belongs to you. --}}
    <div class="w-full grid grid-flow-row-dense grid-cols-1 md:grid-cols-3 gap-4">
        @if($leaves->count() == 0)
        <div class="text-stone-900 text-sm font-semibold">
            No employees on-leave
        </div>
        @endif
        @foreach($leaves as $leave)
            <div class="col-span-1 rounded-xl bg-white hover:shadow-lg hover:shadow-stone-200 border border-stone-200">
                <div class="block h-fit py-2">
                    <div class="flex justify-between">
                        <div class="flex items-center text-sm">
                            <span class="h-12 w-0.5 mr-3 bg-indigo-500"></span>
                            <!-- Avatar with inset shadow -->
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block" >
                                <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $leave->user->profile_photo_path ) }}" alt="" loading="lazy" />
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $leave->user->formal_name() }}</p>
                                <p class="text-xs text-stone-600 ">
                                    {{ $leave->user->code }}
                                </p>
                            </div>
                        </div>
                        <div class="text-xs text-stone-400 px-2 flex items-center">
                            <i class="fa-solid fa-clock mr-2"></i>
                            {{ Carbon\Carbon::parse($leave->created_at)->format('F d, Y') }}
                        </div>
                    </div>
                </div>
                <div class="block h-fit border-t border-stone-100">
                    <div class="py-4 px-8 flex justify-between space-x-4">
                        <div class="">
                            <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ Carbon\Carbon::parse($leave->start_date)->format('F') }}</div>
                            <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ Carbon\Carbon::parse($leave->start_date)->format('d') }}</div>
                            <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ Carbon\Carbon::parse($leave->start_date)->format('D') }}</div>
                        </div>
                        <div class="">
                            <div class="block text-indigo-500 text-center">
                                <i class="fa-solid fa-ellipsis fa-2x"></i>
                                <i class="fa-solid fa-arrow-right-long fa-2x"></i>
                            </div>
                            <div class="block text-stone-500 text-xs text-center lowercase">
                                {{ $leave->hours_duration }}hrs {{ $leave->leaveType->name }}
                            </div>
                        </div>
                        <div class="">
                            <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $leave->end_date ? Carbon\Carbon::parse($leave->end_date)->format('F'): 'N/A' }}</div>
                            <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $leave->end_date ? Carbon\Carbon::parse($leave->end_date)->format('d') : 'N/A' }}</div>
                            <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $leave->end_date ? Carbon\Carbon::parse($leave->end_date)->format('D') : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="bg-stone-100 py-4 px-8">
                        <p class="line-clamp-4 text-left text-stone-500 text-xs">
                            {{ $leave->reason }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
