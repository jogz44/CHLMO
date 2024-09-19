@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'pl-10 p-2 bg-white shadow text-sm border border-gray-300 rounded-full w-full focus:outline-none focus:ring-2 focus:ring-green-300 placeholder-gray-400']) !!}>
{{--<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>--}}
