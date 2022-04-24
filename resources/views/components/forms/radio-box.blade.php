@props(['disabled' => false])
<input type="radio"{{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer']) }}>
