<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $status;

    protected $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
        $this->task = Task::factory()->create(['created_by_id' => $this->user->id,
                                                'status_id' => $this->status->id,
                                            ]);
    }

    public function testGuestCannotAccessTasks()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(403);
    }

    public function testAuthenticatedUserCanViewTasks()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testAuthenticatedUserCanViewSingleTask()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.show', $this->task));
        $response->assertStatus(200);
    }

    public function testAuthenticatedUserCanCreateTask()
    {
        $data = ['name' => 'Test Task',
                'status_id' => $this->status->id,
                ];
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['name' => 'Test Task',
                                           'created_by_id' => $this->user->id,
                                            ]);
        $this->assertTrue($this->user->createdTasks->contains($this->task));
    }

    public function testTaskRequiresName()
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), ['status_id' => $this->status->id]);
        $response->assertSessionHasErrors('name');
    }

    public function testAuthenticatedUserCanUpdateTask()
    {
        $response = $this->actingAs($this->user)->put(route('tasks.update', $this->task), ['name' => 'Updated',
                                                                                        'status_id' => $this->status->id,
                                                                                        ]);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id,
                                            'name' => 'Updated',
                                         ]);
        $this->assertTrue($this->user->createdTasks->contains($this->task));
    }

    public function testCreatorCanDeleteTask()
    {
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $this->task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }

    public function testNonCreatorCannotDeleteTask()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $otherUser->id,
                                        'status_id' => $this->status->id,
                                    ]);
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
        $this->assertFalse($this->user->createdTasks->contains($task));
        $this->assertTrue($otherUser->createdTasks->contains($task));
        $response->assertStatus(403);
    }
}
