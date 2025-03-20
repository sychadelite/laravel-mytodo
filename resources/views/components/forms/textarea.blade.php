@props(['name', 'placeholder' => '', 'required' => false])

<textarea name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
  {{ $attributes->merge(['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}>{{ $slot }}</textarea>
