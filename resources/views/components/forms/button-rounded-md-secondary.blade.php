<!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
<button {{ $attributes->merge(['type' => 'submit','class' => 'bg-stone-200 hover:bg-stone-300 disabled:hover:bg-stone-200 px-5 py-2 h-full text-xs font-bold tracking-wide text-stone-900 rounded-md']) }}>
    {{ $slot }}
</button>   