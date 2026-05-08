<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    protected $model = TaskStatus::class;

    public function definition(): array
    {
        return [
            'name' => 'Status ' . Str::lower($this->faker->unique()->lexify('?????')),
            'color' => $this->faker->hexColor(),
        ];
    }
}
