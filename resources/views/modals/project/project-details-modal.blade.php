
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
                                    {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : '' }}
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


{{-- modal loan details --}}
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