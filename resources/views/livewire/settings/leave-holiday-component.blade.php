<div>
    
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- left --}}
        <div class="col-span-2 md:col-span-1">
            <div class="flex justify-between">
                <p class="font-bold mb-4">Leave Types</p>
                <button onclick="modalObject.openModal('modalAddLeaveType')" class="text-blue-500 flex items-center justify-center px-2 py-2 cursor-pointer text-xs">
                    New Leave Type<i class="fa-solid fa-plus fa-xs ml-2"></i>
                </button>
            </div>
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3 text-center">Days</th>
                                <th class="px-4 py-3 text-right">Active</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y "  >
                            @foreach($leave_types as $leave_type)
                                <tr class="text-stone-700 cursor-pointer">
                                    <td wire:click="editLeaveTypeModal({{ $leave_type->id }})" class="px-4 py-3 text-xs whitespace-nowrap">
                                        {{ $leave_type->name }}
                                    </td>
                                    <td class="px-4 py-3 text-xs whitespace-nowrap text-center">
                                        {{ $leave_type->days }}
                                    </td>
                                    <td class="px-4 py-3 text-sm  flex justify-end">
                                        @livewire('components.toggle-button', ['field' => 'is_active', 'model' => $leave_type], key($leave_type->id))
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- right --}}
        <div class="col-span-2 md:col-span-1">

            <div class="flex justify-between">
                <p class="font-bold mb-4">Holidays</p>
                <button onclick="modalObject.openModal('modalAddHoliday')" class="text-blue-500 flex items-center justify-center px-2 py-2 cursor-pointer text-xs">
                    New Holiday<i class="fa-solid fa-plus fa-xs ml-2"></i>
                </button>
            </div>

            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3 text-center">Date</th>
                            <th class="px-4 py-3 text-right">Type</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y "  >
                            @foreach($holidays as $holiday)
                                <tr class="text-stone-700 cursor-pointer" wire:click="editHolidayModal({{ $holiday->id }})" wire:key="{{$holiday->id}}">
                                    <td class="px-4 py-3 text-xs whitespace-nowrap">
                                        {{ $holiday->name }}
                                    </td>
                                    <td class="px-4 py-3 text-xs whitespace-nowrap text-center">
                                        {{ Carbon\Carbon::parse($holiday->date)->format('F d, Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-xs whitespace-nowrap text-center">
                                        {{ $holiday->is_legal ? 'Legal' : 'Special' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @include('modals.settings.leave-holiday-modal')
    
</div>
