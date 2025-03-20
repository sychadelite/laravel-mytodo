@props(['tasks'])

<div class="mt-8">
  <h2 class="text-left text-base font-bold text-gray-800 mb-4">Ongoing Tasks</h2>
  <div class="text-left space-y-4">
    @forelse ($tasks as $task)
      <div class="bg-[#d0d0d0] p-4 rounded-lg shadow-md">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <div class="flex flex-wrap gap-1">
              <h3 class="text-lg font-semibold text-gray-700">{{ $task->title }}</h3>
              <a href="{{ route('tasks.edit', $task->id) }}"
                class="w-fit text-black font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline flex items-center justify-center">
                <i data-lucide="pencil" class="w-4 h-4"></i>
              </a>
            </div>
            <p class="text-gray-600 mt-2">{{ $task->description }}</p>
            @php
              $formattedTime = $task->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i');
            @endphp
            <p class="text-gray-600 mt-2">{{ $formattedTime }}</p>
          </div>
          <div class="flex flex-wrap justify-center items-center gap-3">
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="bg-transparent hover:bg-red-400 text-black ring-2 ring-black font-bold p-1 rounded-full focus:outline-none focus:shadow-outline cursor-pointer">
                <i data-lucide="x" class="w-3 h-3"></i>
              </button>
            </form>
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="completed" value="1">
              <button type="submit"
                class="group bg-white hover:bg-green-400 text-black ring-2 ring-black font-bold p-1 rounded-full focus:outline-none focus:shadow-outline cursor-pointer flex items-center justify-center">
                <!-- Hidden by default, shown on button hover -->
                <i data-lucide="check" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="text-gray-600">No ongoing tasks found.</p>
    @endforelse
  </div>
</div>
