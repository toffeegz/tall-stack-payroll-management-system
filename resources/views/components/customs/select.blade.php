<!-- Be present above all else. - Naval Ravikant -->
@props(['disabled' => false])
<select {{ $attributes->merge(['class' => 'w-full text-xs rounded-sm border-stone-200 focus:border-stone-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>