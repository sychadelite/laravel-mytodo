@extends('layouts.app')

@section('content')
  <div class="text-center max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <!-- Task Form -->
    <h1 class="text-4xl font-normal mb-6 text-gray-800">Welcome to Task Management System</h1>

    <x-buttons.primary type="button" class="flex flex-nowrap items-baseline justify-center gap-1 mx-auto cursor-pointer" onclick="window.location.href='{{ route('tasks.create') }}'">
      <i data-lucide="plus" class="w-3 h-3 max-sm:hidden"></i>
      Create Task
    </x-buttons.primary>

    <!-- Ongoing Tasks -->
    <x-ongoing-tasks :tasks="$pendingTasks" />

    <!-- Completed Tasks -->
    <x-completed-tasks :tasks="$completedTasks" />
  </div>
@endsection
