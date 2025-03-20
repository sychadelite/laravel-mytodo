<form action="{{ $action }}" method="POST">
  @csrf
  @if ($method === 'PUT')
    @method('PUT')
  @endif

  <div class="text-start mb-4">
    <label class="block text-gray-700 text-sm font-normal mb-2" for="title">
      Title
    </label>
    <x-forms.input name="title" id="title" placeholder="Enter task title" value="{{ $task->title ?? '' }}" required />
  </div>

  {{-- <div class="text-start mb-6">
    <label class="block text-gray-700 text-sm font-normal mb-2" for="description">
      Task Description
    </label>
    <x-forms.textarea name="description" id="description" placeholder="Enter task description" required>{{ $task->description ?? '' }}</x-forms.textarea>
  </div> --}}

  <div class="flex items-center justify-center gap-4">
    @if ($method === 'POST')
      <x-buttons.primary type="submit" class="cursor-pointer">
        {{ $buttonText }}
      </x-buttons.primary>
    @else
      <x-buttons.warning type="submit" class="cursor-pointer">
        {{ $buttonText }}
      </x-buttons.warning>
      <x-buttons.danger type="button" class="cursor-pointer bg-gray-500 hover:bg-gray-700" onclick="window.location.href='{{ route('tasks.index') }}'">
        Cancel
      </x-buttons.danger>
    @endif
  </div>
</form>
