<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    
    <dialog {{ $attributes->merge(['id'=> $id,'class' => 'bg-transparent z-0 relative w-screen h-screen']) }}>
        <div class="p-7 flex justify-center items-start overflow-x-hidden overflow-y-auto fixed left-0 top-0 w-full h-full bg-stone-900 bg-opacity-50 z-50 transition-opacity duration-300">
            <div class="bg-white rounded-xl max-w-sm w-full relative">
                
                {{-- modal body --}}
                <div class="flex flex-col px-4 w-full">
                    {{ $slot }}
                </div>
                {{-- end modal body --}}
            </div>
        </div>
    </dialog>
</div>