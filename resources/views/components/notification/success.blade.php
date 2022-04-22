<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <div class="w-full flex items-center justify-center">
        <img src="{{ asset('storage/img/icons/check.png') }}" 
            class="h-20 w-20 object-cover"
        />
    </div>
    <div>
        <h3 class="text-lg font-bold py-4 ">{{ $title }}</h3>
        <p class="text-sm text-gray-500 px-8">
            {{ $slot }}
        </p>
    </div>
</div>