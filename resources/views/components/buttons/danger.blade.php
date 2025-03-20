<button {{ $attributes->merge(['class' => 'bg-red-500 hover:bg-red-700 text-white font-normal py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline']) }}>
  {{ $slot }}
</button>
