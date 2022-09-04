


{{-- modal notif hours --}}
<x-modal-small id="modalNotif" title="Success" wire:ignore.self>
    {{-- modal body --}}
    <div class="text-center p-5 flex-auto justify-center">
        <x-notification.success title="Great!">
            New project has been successfully saved
        </x-notification.success>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}




{{-- modal new project  --}}
<x-modal-small id="modalNewProject" title="New Project" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">
        {{-- project information --}}
        @if($newPage == 1)

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
            

            {{-- name --}}
            <div class="">
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
            <div class="col-span-5 md:col-span-3 space-y-1">
                <x-light-forms.label>
                    Code
                </x-light-forms.label>
                <input type="text" wire:model="code" {{ $auto_generate_code ? 'disabled':'' }} class="w-full text-sm rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:bg-gray-100">
                <div class="ml-2 pt-1 flex">
                    <x-forms.checkbox wire:model="auto_generate_code"></x-forms.checkbox>
                    
                    <x-light-forms.radio-box-label>
                        auto generate code
                    </x-light-forms.radio-box-label>
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
        @elseif($newPage == 2)

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


            <div class="grid grid-cols-2">
                {{-- status --}}
                <div class="w-full">
                    <x-forms.label>
                        Status
                    </x-forms.label>
                    <div class="flex flex-col text-sm">
                        <div class="form-check px-2">
                            <x-forms.radio-box value="1" wire:model="status" name="status" id="status1"></x-forms.radio-box>
                            <x-forms.radio-box-label for="status1">
                                On-going
                            </x-forms.radio-box-label>
                        </div>
                        <div class="form-check px-2">
                            <x-forms.radio-box value="2" wire:model="status" name="status" id="status2"></x-forms.radio-box>
                            <x-forms.radio-box-label for="status2">
                                Finished
                            </x-forms.radio-box-label>
                        </div>
                        <div class="form-check px-2">
                            <x-forms.radio-box value="3" wire:model="status" name="status" id="status3"></x-forms.radio-box>
                            <x-forms.radio-box-label for="status3">
                                Upcoming
                            </x-forms.radio-box-label>
                        </div>
                        
                    </div>
                    @error('status')
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

            
        @elseif($newPage == 3)
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full">
                    <x-forms.search-input placeholder="search name or date" name="search_user"/>
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
                                            <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                            type="checkbox" value="{{ $user->id }}" wire:model.defer="selected_users">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary wire:click="backPage" >
                {{ $newPage == 1 ? 'Cancel':'Back' }}
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="nextPage" wire:loading.attr="disabled">
                Next
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}
