@extends('layouts.app')

@section('content')
  <div class="text-center max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <!-- Task Form -->
    <h1 class="text-4xl font-normal mb-6 text-gray-800">Task Management</h1>
    <x-forms.task-form action="{{ route('tasks.store') }}" method="POST" buttonText="Add Task" />

    <!-- Ongoing Tasks -->
    <x-ongoing-tasks :tasks="$pendingTasks" />

    <!-- Completed Tasks -->
    <x-completed-tasks :tasks="$completedTasks" />
  </div>
@endsection
