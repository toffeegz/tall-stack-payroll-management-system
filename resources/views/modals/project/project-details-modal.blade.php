

{{-- modal add user  --}}
<x-modal-small id="modalAddUsers" title="Add Employee" wire:ignore.self>

    {{-- modal body --}}
    <div class="space-y-4 my-4">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full">
                <x-forms.search-input placeholder="search name or code" name="search_add"/>
            </div>
            <div class="w-full overflow-x-auto overflow-y-auto scrollbar-hide h-96">
                {{-- no data --}}
                @if($users_to_add->count() == 0)
                    @if($users_to_add->count() == 0)
                        <p class="text-sm text-center h-full flex items-center justify-center text-stone-500 font-bold uppercase">
                            No users found
                        </p>
                    @endif 
                @endif 
                
                <table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y">
                        @foreach($users_to_add as $user)
                            <tr class="text-stone-700 ">
                                <td class="px-2 md:px-4 py-3 flex space-x-2">
                                    <img src="{{ asset('storage/img/users/'.($user->profile_photo_path ? $user->profile_photo_path : 'default.jpg')) }}" class="rounded-full h-9 w-9 object-cover"/>
                                    <div class="">
                                        <p class="text-stone-900 font-bold text-sm">{{ $user->first_name . " " . $user->last_name }}</p>
                                        <p class="text-stone-500 font-semibold text-xs">{{ $user->code }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs font-semibold text-stone-700">
                                    {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : 'N/A' }}
                                </td>
                                <td class="px-2 md:px-4 py-3 w-6">
                                    <div class="form-check">
                                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                        type="checkbox" value="{{ $user->id }}" wire:model="selected_users_to_add">
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
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAddUsers')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="submitUsers" wire:loading.attr="disabled">
                Submit
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}


{{-- modal remove user --}}
<x-modal-small id="modalRemoveUsers" title="Remove Users" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        <x-notification.delete title="Remove Selected Users?">
            Are you sure you want to remove {{ count($selected_users_to_remove) }} users?
        </x-notification.delete>



    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex space-x-2 justify-end border-t border-stone-200 px-4">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalRemoveUsers')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-danger wire:click="removeUsers">
            Remove
        </x-forms.button-rounded-md-danger>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}


{{-- modal update project  --}}
<x-modal-small id="modalUpdateProject" title="Update Project" wire:ignore.self>

    {{-- modal body --}}
    <div class="space-y-4 my-4">
        {{-- project information --}}
        

            {{-- name and code --}}
            <div class="grid grid-cols-3 gap-4">
                {{-- name --}}
                <div class="col-span-3 md:col-span-2">
                    <x-forms.label>
                        Name
                    </x-forms.label>
                    <x-forms.input type="text" class="w-full" wire:model="name">
                    </x-forms.input>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                {{-- code --}}
                <div class="col-span-3 md:col-span-1">
                    <x-forms.label>
                        Code
                    </x-forms.label>
                    <x-forms.input type="text"  class="w-full" wire:model="code">
                    </x-forms.input>
                    @error('code')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- location --}}
            <div>
                <x-forms.label>
                    Location
                </x-forms.label>
                <x-forms.textarea rowspan="2" class="w-full" wire:model="location">
                </x-forms.textarea>
                @error('location')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- start and end date --}}
            <div class="flex justify-between gap-4">
                {{-- date --}}
                <div class="w-full">
                    <x-forms.label>
                        Start Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="start_date"></x-forms.input>
                    @error('start_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                {{-- end date --}}
                <div class="w-full">
                    <x-forms.label>
                        End Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="end_date"></x-forms.input>
                    @error('end_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- details --}}
            <div>
                <x-forms.label>
                    Details
                </x-forms.label>
                <x-forms.textarea rowspan="2" class="w-full" wire:model="details">
                </x-forms.textarea>
                @error('details')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- subcontractual --}}
            <div class="ml-2">
                <x-forms.checkbox wire:model="is_subcontractual"></x-forms.checkbox>
                <x-forms.checkbox-label>
                    Subcontractual
                </x-forms.checkbox-label>
                @error('is_subcontractual')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.openModal('modalUpdateProject')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="updateProject" wire:loading.attr="disabled">
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}

{{-- modal update project  --}}
<x-modal-small id="modalUpdateImage" title="Update Image" wire:ignore.self>

    {{-- modal body --}}
    <div class="space-y-4 my-4">
        {{-- image --}}
        <div class="">
            <div class="w-full">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                    Upload <small class="text-gray-400 ml-2">Image(jpg,png)</small>
                </label> 
                <label class="flex flex-col w-full hover:bg-gray-100">
                    <div class="relative flex flex-col items-center justify-center pt-12 pb-1/4">

                        <img @if($profile_photo_path) src="{{ $profile_photo_path->temporaryUrl() }}" @endif 
                        class="absolute rounded-lg w-full h-full object-cover border-dashed border-4 border-gray-100 inset-0">
                        <i class="far fa-image fa-3x text-gray-300 group-hover:text-gray-400"></i>
                        <p class="pt-1 text-sm tracking-wider font-semibold text-gray-300 group-hover:text-gray-400">
                            Select a photo
                        </p>
                        <input type="file" class="opacity-0" accept="image/*" wire:model="profile_photo_path"/>
                    </div>
                </label>
            </div>
            @error('profile_photo_path')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.openModal('modalUpdateImage')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="updateImage" wire:loading.attr="disabled">
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}


{{-- modal delete project --}}
<x-modal-small id="modalDeleteProject" title="Delete" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        <x-notification.delete title="Delete Project">
            Are you sure you want to delete this project?
        </x-notification.delete>

    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex space-x-2 justify-end border-t border-stone-200 px-4">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalDeleteProject')">
            Cancel
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-danger wire:click="deleteProject">
            Yes
        </x-forms.button-rounded-md-danger>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}  

{{-- modal notif hours --}} 
<x-modal-small id="modalNotif" title="Success" wire:ignore.self>
    {{-- modal body --}}
    <div class="text-center p-5 flex-auto justify-center">
        <x-notification.success title="Great!">
            Users has been added
        </x-notification.success>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}












{{-- modal assign user  --}}
<x-modal-small id="modalAssignTimekeeper" title="Assign Timekeeper" wire:ignore.self>

    {{-- modal body --}}
    <div class="space-y-4 my-4">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full">
                <x-forms.search-input placeholder="search name or code" name="search_add"/>
            </div>
            <div class="w-full overflow-x-auto overflow-y-auto scrollbar-hide h-96">
                {{-- no data --}}
                @if($users->count() == 0)
                    @if($users->count() == 0)
                        <p class="text-sm text-center h-full flex items-center justify-center text-stone-500 font-bold uppercase">
                            No users found
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
                                        <p class="text-stone-900 font-bold text-sm">{{ $user->first_name . " " . $user->last_name }}</p>
                                        <p class="text-stone-500 font-semibold text-xs">{{ $user->code }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs font-semibold text-stone-700">
                                    {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : 'N/A' }}
                                </td>
                                <td class="px-2 md:px-4 py-3 w-6">
                                    <div class="form-check">
                                        <x-forms.radio-box name="timekeeper" wire:model="selected_timekeeper" value="{{ $user->id }}"></x-forms.radio-box>
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
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAssignTimekeeper')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="assignTimekeeper" wire:loading.attr="disabled">
                Submit
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}


