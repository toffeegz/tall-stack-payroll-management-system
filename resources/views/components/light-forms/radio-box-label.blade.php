<!-- Order your soul. Reduce your wants. - Augustine -->
@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm form-check-label inline-block text-gray-800 ']) }}>
    {{ $value ?? $slot }}
</label>
