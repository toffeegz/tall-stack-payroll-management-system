<!-- Order your soul. Reduce your wants. - Augustine -->
@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold tracking-wide text-sm text-stone-900']) }}>
    {{ $value ?? $slot }}
</label>
