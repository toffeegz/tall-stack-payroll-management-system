<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="space-y-4">

        @if($errors->any())
            <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-red-50 rounded-xl border border-red-100 focus:outline-none focus:shadow-outline-stone">
                <div class="flex flex-row space-x-4 w-full">
                    <div class="flex items-center bg-red-100 rounded-md p-2 h-16">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#f63b3b;"><path d="M 24 4 C 12.972292 4 4 12.972292 4 24 C 4 27.275316 4.8627078 30.334853 6.2617188 33.064453 L 4.09375 40.828125 C 3.5887973 42.631528 5.3719261 44.41261 7.1757812 43.908203 L 14.943359 41.740234 C 17.671046 43.137358 20.726959 44 24 44 C 35.027708 44 44 35.027708 44 24 C 44 12.972292 35.027708 4 24 4 z M 24 7 C 33.406292 7 41 14.593708 41 24 C 41 33.406292 33.406292 41 24 41 C 20.997029 41 18.192258 40.218281 15.744141 38.853516 A 1.50015 1.50015 0 0 0 14.609375 38.71875 L 7.2226562 40.78125 L 9.2851562 33.398438 A 1.50015 1.50015 0 0 0 9.1503906 32.263672 C 7.7836522 29.813476 7 27.004518 7 24 C 7 14.593708 14.593708 7 24 7 z M 23.976562 12.978516 A 1.50015 1.50015 0 0 0 22.5 14.5 L 22.5 26.5 A 1.50015 1.50015 0 1 0 25.5 26.5 L 25.5 14.5 A 1.50015 1.50015 0 0 0 23.976562 12.978516 z M 24 31 A 2 2 0 0 0 24 35 A 2 2 0 0 0 24 31 z"></path></svg>
                    </div>
                    <div class="w-full">
                        <div class="font-bold text-base text-red-600">Oh no! There was an error</div>
                        <div class="text-stone-500 text-xs font-light grid grid-cols-3 w-full">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-5 gap-4 ">
            <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                Employment Status:
            </div>
            <div class="col-span-3 text-stone-900 text-sm font-semibold">
                <a href="#" wire:click="openModal('employment_status')" class="hover:text-blue-500">Full-Time Contract</a>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-4 ">
            <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                Hired Date:
            </div>
            <diiv class="col-span-3 text-stone-900 text-sm font-semibold">
                <a href="" class="hover:text-blue-500">July 04, 2022</a>
            </diiv>
        </div>

        <div class="grid grid-cols-5 gap-4 ">
            <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                Paid Holidays
            </div>
            <div class="col-span-3 text-stone-900 text-sm font-semibold">
                <a href="" class="hover:text-blue-500">Yes</a>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-4 ">
            <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                Tax Exempted
            </div>
            <div class="col-span-3 text-stone-900 text-sm font-semibold">
                <a href="" class="hover:text-blue-500">No</a>
            </div>
        </div>

        <div class="rounded-md bg-gray-100 space-y-4 pb-8">
            <div class="w-full flex mb-2 p-8">
                <div class="flex-none text-stone-500 text-sm font-bold tracking-wide">
                    Tax Details
                </div>
                <hr class="text-stone-500 flex-auto my-2 mx-2">
            </div>
            <div class="grid grid-cols-5 gap-4 ">
                <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                    SSS Number
                </div>
                <div class="col-span-3 text-stone-900 text-sm font-semibold">
                    809-030-873-5512
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 ">
                <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                    PhilHealth Number
                </div>
                <div class="col-span-3 text-stone-900 text-sm font-semibold">
                    809-030-873-5512
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 ">
                <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                    Pag-Ibig Number
                </div>
                <div class="col-span-3 text-stone-900 text-sm font-semibold">
                    809-030-873-5512
                </div>
            </div>
        </div>

        <div class="rounded-md bg-gray-100 space-y-4 pb-8">
            <div class="w-full flex mb-2 p-8">
                <div class="flex-none text-stone-500 text-sm font-bold tracking-wide">
                    Compensation
                </div>
                <hr class="text-stone-500 flex-auto my-2 mx-2">
            </div>
            <div class="grid grid-cols-5 gap-4 ">
                <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                    Department
                </div>
                <div class="col-span-3 text-stone-900 text-sm font-semibold">
                    Operation Department
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 ">
                <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                    Job Title
                </div>
                <div class="col-span-3 text-stone-900 text-sm font-semibold">
                    Laravel & Vue JS Developer
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 ">
                <div class="col-span-2 text-stone-500 text-sm font-bold tracking-wide flex justify-end items-center">
                    Daily Rate
                </div>
                <div class="col-span-3 text-stone-900 text-sm font-semibold">
                    ₱ 700.00
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        // Your JS here.
        console.log('testing');
    </script>
    @endpush
</div>

