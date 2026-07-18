@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-toko-green focus:ring-toko-green rounded-lg shadow-sm transition duration-150']) !!}>
