<?php

namespace App\DTO;

use Carbon\Carbon;

class TaskDTO
{
    public int $id;
    public string $title;
    public ?string $description;
    public bool $completed;
    public Carbon $created_at;
    public Carbon $updated_at;

    public function __construct(
        int $id,
        string $title,
        ?string $description,
        bool $completed,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
        $this->created_at = Carbon::parse($created_at);
        $this->updated_at = Carbon::parse($updated_at);
    }

    /**
     * Create a TaskDTO from an array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['title'],
            $data['description'] ?? null,
            $data['completed'],
            $data['created_at'],
            $data['updated_at']
        );
    }
}
