<!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
<button {{ $attributes->merge(['type' => 'submit','class' => 'shadow-sm hover:shadow-lg mb-2 md:mb-0 hover:bg-blue-500 border hover:border-blue-500 px-5 py-2 text-sm font-medium tracking-wider text-white rounded-full bg-stone-900 border-stone-900 disabled:bg-stone-200 disabled:border-stone-200 disabled:text-stone-900']) }}>
    {{ $slot }}
</button>   