<button {{ $attributes->merge(['class' => 'bg-[#6ecbff] hover:bg-blue-300 text-black font-normal py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline']) }}>
  {{ $slot }}
</button>
