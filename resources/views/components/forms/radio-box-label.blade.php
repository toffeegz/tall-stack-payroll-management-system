<!-- Order your soul. Reduce your wants. - Augustine -->
@props(['value'])

<label {{ $attributes->merge(['class' => 'form-check-label inline-block text-gray-800 mt-1 ']) }}>
    {{ $value ?? $slot }}
</label>
