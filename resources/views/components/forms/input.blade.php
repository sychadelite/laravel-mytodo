@props(['name', 'type' => 'text', 'placeholder' => '', 'value' => '', 'required' => false])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}" {{ $required ? 'required' : '' }}
  {{ $attributes->merge(['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }} />
