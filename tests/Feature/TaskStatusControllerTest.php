<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_statuses_page()
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.index'));
        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.index');
    }

    public function test_create_returns_create_page()
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.create');
    }

    public function test_store_creates_new_status()
    {
        $data = ['name' => 'Test Status'];

        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);

        $this->assertDatabaseHas('task_statuses', $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
    }

    public function test_store_validates_name_required()
    {
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), ['name' => '']);
        $response->assertSessionHasErrors('name');
    }

    public function test_edit_returns_edit_page()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $status));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.edit');
    }

    public function test_update_modifies_status()
    {
        $status = TaskStatus::factory()->create(['name' => 'Old Name']);
        $newData = ['name' => 'New Name'];

        $response = $this->actingAs($this->user)->put(route('task_statuses.update', $status), $newData);

        $this->assertDatabaseHas('task_statuses', $newData);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
    }

    public function test_guest_cannot_access_statuses()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertRedirect(route('index'));
    }
}
