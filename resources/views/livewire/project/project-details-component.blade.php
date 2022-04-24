<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto px-6 md:px-32">

        {{-- header --}}
        <div class="ml-12 md:ml-0 mt-20 mb-6 space-x-4">
            <div class="flex items-center text-sm">
                <!-- Avatar with inset shadow -->
                <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block" >
                    <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/projects/'. $project->profile_photo_path) }}" alt="" loading="lazy" />
                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                </div>
                <div>
                    <p class="font-semibold text-2xl">{{ $project->name }}</p>
                    <p class="text-lg text-stone-600 ">
                        {{ $project->code }}
                    </p>
                </div>
            </div>

        </div>

        {{-- body --}}
        <div class=" w-full grid grid-cols-3 gap-4">

            <div class="col-span-3 md:col-span-2">
                 
            </div>

            {{-- right panel --}}
            <div class="col-span-3 md:col-span-1">

            </div>

        </div>
    </div>

    {{--  --}}
    {{-- @include('scripts.employee.profile-script')
    @include('modals.employee.profile-modal') --}}
</div>
