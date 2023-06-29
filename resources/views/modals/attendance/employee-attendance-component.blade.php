{{-- modal add attendance --}}
<x-modal-small id="modalAddAttendance" title="Add Attendance" wire:ignore.self>
    
        <div class="space-y-4 my-4">
            <div class="">
                <x-forms.label>
                    Project
                </x-forms.label>
                <x-forms.select wire:model="project_id">
                    <option value="">- N/A -</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach 
                </x-forms.select>
            </div>
        </div>
        {{-- modal footer --}}
        <div class="flex justify-between py-4 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAddAttendance')">
                Cancel
            </x-forms.button-rounded-md-secondary>
        
            <x-forms.button-rounded-md-primary wire:click="create" >
                Time In
            </x-forms.button-rounded-md-primary>
        </div>
        {{-- end modal footer --}}

</x-modal-small>
{{-- end modal add attendance --}}

{{-- modal notif --}}
<x-modal-small id="modalNotif" title="Success" wire:ignore.self>
    {{-- modal body --}}
    <div class="text-center p-5 flex-auto justify-center">
        <x-notification.success title="Great!">
            @if($notif_message == 'not import')
                @if($hide == false)
                <div class="space-y-4 mt-4">
                    {{--<div>
                        <p class="font-semibold text-sm text-stone-600">
                            {{ $updated_count }} updated and {{ $added_count }} added succesfully.
                        </p>
                    </div>--}}
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
            @else 
            {{ $notif_message }}
            @endif
        </x-notification.success>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}