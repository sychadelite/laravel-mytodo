<button {{ $attributes->merge(['class' => 'bg-yellow-500 hover:bg-yellow-600 text-black font-normal py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline']) }}>
  {{ $slot }}
</button>
