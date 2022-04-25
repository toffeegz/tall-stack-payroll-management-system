<!-- Order your soul. Reduce your wants. - Augustine -->
@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold tracking-wide text-sm text-stone-500']) }}>
    {{ $value ?? $slot }}
</label>
