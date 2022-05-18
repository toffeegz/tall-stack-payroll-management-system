@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'w-full text-sm font-semibold rounded-md border-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50']) }}>
