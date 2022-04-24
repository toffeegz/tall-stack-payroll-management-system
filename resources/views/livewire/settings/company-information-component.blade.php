<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="grid grid-cols-10 gap-4">

        {{-- left --}}
        <div class="col-span-10 md:col-span-6">

            <div>
                <p class="font-bold mb-4">Departments</p>

                <div class="px-2 space-y-2">
                    @foreach($departments as $department)
                        <div x-data="{ open: false }">
                            <div class="flex justify-between border-b border-stone-200 py-1">
                                <a x-on:click="open = !open" class="text-sm font-semibold text-stone-600 cursor-pointer">{{ $department->department_name }}</a>
                                <div class="flex space-x-2">
                                    <button wire:click="editDepartmentNameModal({{ $department->id }})" class="flex items-center justify-center px-2 py-2 cursor-pointer">
                                        <i class="fa-solid fa-pen fa-xs text-blue-500"></i>
                                    </button>
                                    <button wire:click="addDesignationModal({{ $department->id }})" class="flex items-center justify-center px-2 py-2 cursor-pointer">
                                        <i class="fa-solid fa-plus fa-xs text-blue-500"></i>
                                    </button>
                                </div>
                            </div>
                            <div x-show="open" class="space-y-2 px-8 my-4">
                                @foreach($department->designations as $designation)
                                    <div class="text-sm flex justify-between">
                                        <p>{{ $designation->designation_name }}</p>
                                        <div class="flex space-x-2">
                                            <p class="text-xs font-semibold text-stone-500">₱{{ $designation->daily_rate }}</p>
                                            <button wire:click="editDesignationModal({{ $designation->id }})" class="flex items-center justify-center px-2 py-2 cursor-pointer">
                                                <i class="fa-solid fa-pen fa-xs text-blue-500"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            

        </div>

        {{-- right --}}
        <div class="col-span-10 md:col-span-4">
            <div class="border border-stone-200 rounded-lg">
                <div x-data="{ hoverImage: false }" @mouseover.away = "hoverImage = false" >
                    <div class="w-full flex justify-center">
                        <img  @mouseover="hoverImage = true" src="{{ asset('storage/img/company/'.Helper::getCompanyInformation()->logo_path) }}" 
                        class=" rounded-lg w-28 h-28 object-cover inset-0">
                    </div>
                </div>


                <div class="p-4">
                    <div class="flex justify-between">
                        <p class="font-bold">Company</p>
                        <button onclick="modalObject.openModal('modalEditCompanyInformation')" class="cursor-pointer text-blue-500 text-xs font-semibold">
                            Edit <i class="fa-solid fa-pen ml-2"></i>
                        </button>
                    </div>
                    

                    <div class="grid grid-cols-3 gap-2 py-2">
                        <div class="col-span-1 text-right text-stone-500 font-semibold text-sm">
                            Name
                        </div>
                        <div class="col-span-2 text-left text-sm">
                            {{ Helper::getCompanyInformation()->name }}
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 py-2">
                        <div class="col-span-1 text-right text-stone-500 font-semibold text-sm">
                            Email
                        </div>
                        <div class="col-span-2 text-left text-sm">
                            {{ Helper::getCompanyInformation()->email }}
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 py-2">
                        <div class="col-span-1 text-right text-stone-500 font-semibold text-sm">
                            Phone #
                        </div>
                        <div class="col-span-2 text-left text-sm">
                            {{ Helper::getCompanyInformation()->phone }}
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 py-2">
                        <div class="col-span-1 text-right text-stone-500 font-semibold text-sm">
                            Address
                        </div>
                        <div class="col-span-2 text-left text-sm">
                            {{ Helper::getCompanyInformation()->address }}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>



    </div>
    @include('modals.settings.company-information-modal')
    @include('scripts.settings.company-information-script')
</div>
