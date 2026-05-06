<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $status;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
    }
    
    public function test_guest_cannot_access_tasks()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertRedirect(route('index'));
    }
    
    public function test_authenticated_user_can_view_tasks()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));
        $response->assertStatus(200);
    }
    
    public function test_authenticated_user_can_view_single_task()
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id, 'status_id' => $this->status->id]);
        $response = $this->actingAs($this->user)->get(route('tasks.show', $task));
        $response->assertStatus(200);
    }
    
    public function test_authenticated_user_can_create_task()
    {
        $data = ['name' => 'Test Task', 'status_id' => $this->status->id];
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['name' => 'Test Task', 'created_by_id' => $this->user->id]);
    }
    
    public function test_task_requires_name()
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), ['status_id' => $this->status->id]);
        $response->assertSessionHasErrors('name');
    }
    
    public function test_authenticated_user_can_update_task()
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id, 'status_id' => $this->status->id]);
        $response = $this->actingAs($this->user)->put(route('tasks.update', $task), ['name' => 'Updated', 'status_id' => $this->status->id]);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => 'Updated']);
    }
    
    public function test_creator_can_delete_task()
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id, 'status_id' => $this->status->id]);
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
    
    public function test_non_creator_cannot_delete_task()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $otherUser->id, 'status_id' => $this->status->id]);
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}