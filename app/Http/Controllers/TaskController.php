<?php

namespace App\Http\Controllers;

use App\DTO\TaskDTO;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch tasks from the Python service
        $pendingTasks = $this->fetchTasks('ongoing');
        $completedTasks = $this->fetchTasks('completed');

        // $pendingTasks = Task::where('completed', false)->orderBy('created_at', 'asc')->get();
        // $completedTasks = Task::where('completed', true)->orderBy('created_at', 'desc')->get();

        return view('tasks.index', compact('pendingTasks', 'completedTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendingTasks = Task::where('completed', false)->orderBy('created_at', 'asc')->get();
        $completedTasks = Task::where('completed', true)->orderBy('created_at', 'desc')->get();

        return view('tasks.create', compact('pendingTasks', 'completedTasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new task with the validated data
        Task::create([
            'title' => $validatedData['title'],
            'description' => isset($validatedData['description']) ? $validatedData['description'] : null,
            'completed' => false, // Default value for new tasks
        ]);

        return redirect()->route('tasks.create')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pendingTasks = Task::where('completed', false)->orderBy('created_at', 'asc')->get();
        $completedTasks = Task::where('completed', true)->orderBy('created_at', 'desc')->get();

        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('pendingTasks', 'completedTasks', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        // Check if the request only has the 'completed' field
        if ($request->has('completed') && count($request->all()) === 1) {
            // Update only the 'completed' field
            $task->update(['completed' => $validatedData['completed']]);
        } else {
            // Update only the fields present in the request
            $task->update($request->only(['title', 'description', 'completed']));
        }

        return redirect()->route('tasks.create')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * Fetch tasks from the Python service.
     */
    public function fetchTasks(?string $status = null): Collection
    {
        try {
            // Build query parameters based on the status
            $queryParams = [];
            if ($status === 'ongoing') {
                $queryParams['completed'] = 'false';
            } elseif ($status === 'completed') {
                $queryParams['completed'] = 'true';
            }

            // Make a GET request to the Python service with optional query parameters
            $response = Http::get(env('PYTHON_SERVICE_URL') . '/tasks', $queryParams);

            // Check if the request was successful
            if ($response->successful()) {
                // Convert the JSON response to a collection of TaskDTO objects
                return collect($response->json()['data'])
                    ->map(fn($task) => TaskDTO::fromArray($task));
            } else {
                // Log the error or handle it as needed
                Log::error('Failed to fetch tasks from Python service: ' . $response->status());
                return collect(); // Return an empty collection
            }
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            Log::error('Error fetching tasks from Python service: ' . $e->getMessage());
            return collect(); // Return an empty collection
        }
    }
}
