  {{-- modal add attendance --}}
  <x-modal-small id="modalAddAttendance" title="Add Attendance" wire:ignore.self>
    {{-- modal body --}}
    @if($next_page_attendance ==  false && $hide == false)
        <div class="space-y-4 mt-4">
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full">
                    <x-forms.search-input placeholder="search employee name or code" name="search_add"/>
                </div>
                <div class="w-full overflow-x-auto overflow-y-auto scrollbar-hide h-96">
                    {{-- no data --}}
                    @if($users->count() == 0)
                        @if($users->count() == 0)
                            <p class="text-sm text-center h-full flex items-center justify-center text-stone-500 font-bold uppercase">
                                No user found
                            </p>
                        @endif 
                    @endif 
                    
                    <table class="w-full whitespace-no-wrap">
                        <tbody class="bg-white divide-y">
                            @foreach($users as $user)
                                <tr class="text-stone-700 ">
                                    <td class="px-2 md:px-4 py-3 flex space-x-2">
                                        <img src="{{ asset('storage/img/users/'.($user->profile_photo_path ? $user->profile_photo_path : 'default.jpg')) }}" class="rounded-full h-9 w-9 object-cover"/>
                                        <div class="">
                                            <p class="text-stone-900 font-bold text-sm">{{ $user->informal_name() }}</p>
                                            <p class="text-stone-500 font-semibold text-xs">{{ $user->code }}</p>
                                        </div>
                                    </td>
                                    <td class="px-2 md:px-4 py-3 w-6">
                                        <p class="text-stone-500 font-bold text-xs whitespace-nowrap">
                                            {{-- {{ $user->position ? $user->position->name : 'N/A'}} --}}
                                        </p>
                                    </td>
                                    <td class="px-2 md:px-4 py-3 w-6">
                                        <div class="form-check">
                                            <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                            type="checkbox" value="{{ $user->id }}" wire:model="selected_users_add_attendance">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="space-y-4 my-4">
            {{-- project --}}
            @if(Auth::user()->hasRole('timekeeper') == false)
            <div class="">
                <x-forms.label>
                    Project
                </x-forms.label>
                <x-forms.select wire:model="selected_project_add_attendance">
                    <option value="">- N/A -</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach 
                </x-forms.select>
            </div>
            @endif
            
            @error('selected_project_add_attendance')
                @if(Auth::user()->hasRole('timekeeper'))
                    <p class="text-red-500 text-xs italic">No project found</p>
                @else
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @endif
            @enderror
            {{-- date --}}
            <div class="">
                <x-forms.label>
                    Date
                </x-forms.label>
                <x-forms.input type="date" wire:model="date_add_attendance"></x-forms.input>
                @error('date_add_attendance')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            {{-- time in and out --}}
            <div class="flex justify-between space-x-4">
                {{-- time in --}}
                <div class="w-full">
                    <x-forms.label>
                        Time In
                    </x-forms.label>
                    <x-forms.input type="time" wire:model="time_in_add_attendance"></x-forms.input>
                    @error('time_in_add_attendance')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                {{-- time out --}}
                <div class="w-full">
                    <x-forms.label>
                        Time Out
                    </x-forms.label>
                    <x-forms.input type="time" wire:model="time_out_add_attendance"></x-forms.input>
                    @error('time_out_add_attendance')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    @endif
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-between border-t border-stone-200">
        <div class="">
            @if($hide == false)
            <span class="text-xs font-semibold text-stone-500">Selected {{ count($selected_users_add_attendance) }} users</span>
            @endif
        </div>
        <div class="flex space-x-2">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEmployees')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            @if(count($selected_users_add_attendance) != 0 && $hide ==  false) 
                @if($next_page_attendance)
                    <x-forms.button-rounded-md-secondary wire:click="backPageAttendance" wire:key>
                        Back
                    </x-forms.button-rounded-md-secondary>
                    <x-forms.button-rounded-md-primary wire:click="submitAddAttendance" >
                        Submit
                    </x-forms.button-rounded-md-primary>
                @else
                    <x-forms.button-rounded-md-primary wire:click="nextPageAttendance" wire:key>
                        Next
                    </x-forms.button-rounded-md-primary>
                @endif 
            @else 
                @if($hide)
                <x-forms.button-rounded-md-primary wire:click="submitAddAttendance" >
                    Submit
                </x-forms.button-rounded-md-primary>
                @else
                <x-forms.button-rounded-md-primary disabled="disabled" >
                    Next
                </x-forms.button-rounded-md-primary>
                @endif
            @endif
            
        </div>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end modal add attendance --}}

{{-- modal approve attendance --}}
<x-modal-small id="modalApproveAttendance" title="Approve Attendance" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 mt-4">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full">
                <x-forms.search-input placeholder="search name or date" name="search_name_or_date_approve_attendance"/>
            </div>
            <div class="w-full overflow-x-auto overflow-y-auto scrollbar-hide h-96">
                {{-- no data --}}
                @if($pending_attendances->count() == 0)
                    @if($pending_attendances->count() == 0)
                        <p class="text-sm text-center h-full flex items-center justify-center text-stone-500 font-bold uppercase">
                            No pending attendance found
                        </p>
                    @endif 
                @endif 
                
                <table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y">
                        @foreach($pending_attendances as $pending_attendance)
                            <tr class="text-stone-700 ">
                                <td class="px-2 md:px-4 py-3 flex space-x-2">
                                    <img src="{{ asset('storage/img/users/'.($pending_attendance->profile_photo_path ? $pending_attendance->profile_photo_path : 'default.jpg')) }}" class="rounded-full h-9 w-9 object-cover"/>
                                    <div class="">
                                        <p class="text-stone-900 font-bold text-sm">{{ $pending_attendance->first_name . " " . $pending_attendance->last_name }}</p>
                                        <p class="text-stone-500 font-semibold text-xs">{{ $pending_attendance->code }}</p>
                                    </div>
                                </td>
                                <td class="px-2 md:px-4 py-3 w-6">
                                    <p class="text-stone-500 font-bold text-xs whitespace-nowrap">
                                        {{ Carbon\Carbon::parse($pending_attendance->date)->format('d/m/Y') }}
                                    </p>
                                </td>
                                <td class="px-2 md:px-4 py-3 w-6">
                                    <div class="form-check">
                                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                        type="checkbox" value="{{ $pending_attendance->id }}" wire:model="selected_attendance_approve_attendance">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full border-t border-stone-200">
        <div class="w-full pt-4">
            <div class="flex justify-between">
                <x-forms.select wire:model="selected_status_approve_attendance">
                    <option value="1">Approve</option>
                    <option value="5">Disapprove</option>
                </x-forms.select>
            </div>
        </div>
        <div class="w-full py-4 flex justify-between">
            <div class="">
                @if($hide == false)
                <span class="text-xs font-semibold text-stone-500">Selected {{ count($selected_attendance_approve_attendance) }} attendances</span>
                @endif
            </div>
            <div class="flex space-x-2">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalApproveAttendance')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                @if(count($selected_attendance_approve_attendance) != 0)
                    <x-forms.button-rounded-md-primary wire:click="submitApproveAttendance" wire:key >
                        Submit
                    </x-forms.button-rounded-md-primary>
                @else
                    <x-forms.button-rounded-md-primary disabled="disabled" >
                        Submit
                    </x-forms.button-rounded-md-primary>
                @endif
                
            </div>
        </div>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end modal approve attendance --}}

{{-- modal notif attendance --}}
<x-modal-small id="modalNotif" title="Notification" wire:ignore.self>
    {{-- modal body --}}
    @if($hide == false)
    <div class="space-y-4 mt-4">
        <div>
            <p class="font-semibold text-sm text-stone-600">
                {{ $updated_count }} updated and {{ $added_count }} added succesfully.
            </p>
        </div>
        <div class="pb-4 flex justify-between space-x-4">
            @if(array_key_exists('Added', $logs))
            <div class="w-full">
                <div class="text-blue-500 font-bold">
                    Added
                </div>
                <div class="px-4">
                    @foreach($logs['Added'] as $user)
                        <p class="text-stone-900 text-xs">
                            {{ $user }}
                        </p>
                    @endforeach
                </div>
            </div>
            @endif
            @if(array_key_exists('Updated', $logs))
            <div class="w-full">
                <div class="text-blue-500 font-bold">
                    Updated
                </div>
                <div class="px-4">
                    @foreach($logs['Updated'] as $user)
                        <p class="text-stone-900 text-xs">
                            {{ $user }}
                        </p>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="space-y-4 mt-4">
        <div class="mb-4">
            <p class="font-semibold text-sm text-stone-600">
                {{ $this->date_add_attendance }} {{ $added_count != 0 ? 'added':'updated'}} succesfully.
            </p>
        </div>
    </div>
    @endif
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end border-t border-stone-200">
        <div class="flex space-x-2">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalNotif')">
                Close
            </x-forms.button-rounded-md-secondary>
        </div>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end modal notif attendance --}}

{{-- modal attendance details --}}
<x-modal-small id="modalAttendanceDetails" title="Attendance" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">
        {{-- project --}}
        @if(Auth::user()->hasRole('timekeeper') == false)
            <div class="">
                <x-forms.label>
                    Project
                </x-forms.label>
                <x-forms.select wire:model="selected_details_project_id">
                    <option value="">- N/A -</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach 
                </x-forms.select>
                @error('selected_details_project_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        @endif
        <div class="">
            <x-forms.label>
                Status
            </x-forms.label>
            @if(Auth::user()->hasRole('administrator'))
                <x-forms.select wire:model="selected_details_status">
                    <option value="4">Pending</option>
                    <option value="1">Approved</option>
                    <option value="5">Disapproved</option>
                </x-forms.select>
                @error('selected_details_status')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            @else
                <div class="w-full text-sm p-2 px-3 rounded-md shadow-sm border border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    {{ $selected_details_status_name }}
                </div>
            @endif
        </div>
        {{-- date --}}
        <div class="">
            <x-forms.label>
                Date
            </x-forms.label>
            @if(Auth::user()->hasRole('administrator') || ($selected_details_status == 4 || $selected_details_status == 5))
                <x-forms.input type="date" wire:model="selected_details_date"></x-forms.input>
                @error('selected_details_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            @else
                <div class="w-full text-sm p-2 px-3 rounded-md shadow-sm border border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    {{ Carbon\Carbon::parse($selected_details_date)->format('d/m/Y') }}
                </div>    
            @endif
        </div>
        {{-- time in and out --}}
        <div class="flex justify-between space-x-4">
            {{-- time in --}}
            <div class="w-full">
                <x-forms.label>
                    Time In
                </x-forms.label>
                @if(Auth::user()->hasRole('administrator') || ($selected_details_status == 4 || $selected_details_status == 5))
                    <x-forms.input type="time" wire:model="selected_details_time_in"></x-forms.input>
                    @error('selected_details_time_in')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                @else
                    <div class="w-full text-sm p-2 px-3 rounded-md shadow-sm border border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        {{ Carbon\Carbon::parse($selected_details_time_in)->format('H:i a') }}
                    </div>
                @endif
            </div>
            {{-- time out --}}
            <div class="w-full">
                <x-forms.label>
                    Time Out
                </x-forms.label>
                @if(Auth::user()->hasRole('administrator') || ($selected_details_status == 4 || $selected_details_status == 5))
                    <x-forms.input type="time" wire:model="selected_details_time_out"></x-forms.input>
                    @error('selected_details_time_out')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                @else
                    <div class="w-full text-sm p-2 px-3 rounded-md shadow-sm border border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        {{ Carbon\Carbon::parse($selected_details_time_out)->format('h:i a') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end border-t border-stone-200">
        <div class="flex space-x-2">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAttendanceDetails')">
                Close
            </x-forms.button-rounded-md-secondary>
            @if(Auth::user()->hasRole('administrator') || ($selected_details_status == 4 || $selected_details_status == 5))
                <x-forms.button-rounded-md-primary wire:click="updateAttendanceDetails" wire:key >
                    Update
                </x-forms.button-rounded-md-primary>
            @endif
        </div>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end modal notif attendance --}}