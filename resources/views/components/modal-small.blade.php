<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    
    <dialog {{ $attributes->merge(['id'=> $id,'class' => 'bg-transparent z-0 relative w-screen h-screen']) }}>
        <div class="p-7 flex justify-center items-start overflow-x-hidden overflow-y-auto fixed left-0 top-0 w-full h-full bg-stone-900 bg-opacity-50 z-50 transition-opacity duration-300">
            <div class="bg-white rounded-xl max-w-lg relative">
                {{-- modal header --}}
                <div class="px-4 pt-4 flex items-center w-full">
                    <div class="text-stone-900 font-bold text-base">
                        {{ $title }}
                    </div>
                    <span class="ml-auto fill-current text-stone-700 w-5 h-5 cursor-pointer"
                        onclick="modalObject.closeModal('{{ $id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-4 h-4" viewBox="0 0 48 48" style=" fill:#000000;"><path d="M 39.486328 6.9785156 A 1.50015 1.50015 0 0 0 38.439453 7.4394531 L 24 21.878906 L 9.5605469 7.4394531 A 1.50015 1.50015 0 0 0 8.484375 6.984375 A 1.50015 1.50015 0 0 0 7.4394531 9.5605469 L 21.878906 24 L 7.4394531 38.439453 A 1.50015 1.50015 0 1 0 9.5605469 40.560547 L 24 26.121094 L 38.439453 40.560547 A 1.50015 1.50015 0 1 0 40.560547 38.439453 L 26.121094 24 L 40.560547 9.5605469 A 1.50015 1.50015 0 0 0 39.486328 6.9785156 z"></path></svg>
                    </span>
                </div>
                {{-- end modal header --}}

                {{-- modal body --}}
                <div class="flex flex-col px-4 w-96 ">
                    {{ $slot }}
                </div>
                {{-- end modal body --}}
            </div>
        </div>
    </dialog>
</div>