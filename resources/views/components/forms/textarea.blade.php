@props(['disabled' => false])
<textarea  {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'w-full text-sm rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50']) }}>
</textarea>
