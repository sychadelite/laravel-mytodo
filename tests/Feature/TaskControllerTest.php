<?php

namespace Tests\Feature;

use App\DTO\TaskDTO;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /**
     * Test fetching all tasks.
     */
    public function testFetchAllTasks()
    {
        // Mock the HTTP response for all tasks
        Http::fake([
            env('PYTHON_SERVICE_URL', 'http://localhost:5000') . '/tasks' => Http::response([
                'data' => [
                    [
                        'id' => 1,
                        'title' => 'Task 1',
                        'description' => null,
                        'completed' => false,
                        'created_at' => '2025-03-18T07:47:07.000000Z',
                        'updated_at' => '2025-03-18T07:47:07.000000Z',
                    ],
                ],
            ]),
        ]);

        // Call the method without a status
        $tasks = $this->fetchTasks();

        // Assert the result
        $this->assertInstanceOf(Collection::class, $tasks);
        $this->assertCount(1, $tasks);
        $this->assertInstanceOf(TaskDTO::class, $tasks->first());
        $this->assertEquals('Task 1', $tasks->first()->title);
    }

    /**
     * Helper method to call the fetchTasks method.
     */
    private function fetchTasks(?string $status = null): Collection
    {
        // This is a placeholder for the actual method in your controller or service.
        // Replace this with the actual method call in your application.
        return app(TaskController::class)->fetchTasks($status);
    }
}
