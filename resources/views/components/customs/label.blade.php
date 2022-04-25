<!-- Order your soul. Reduce your wants. - Augustine -->
@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold tracking-wide text-xs text-stone-500']) }}>
    {{ $value ?? $slot }}
</label>
