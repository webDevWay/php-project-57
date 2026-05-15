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

    public function testIndexReturnsStatusesPage()
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.index'));
        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.index');
    }

    public function testCreateReturnsCreatePage()
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.create');
    }

    public function testStoreCreatesNewStatus()
    {
        $data = ['name' => 'Test Status'];

        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);

        $this->assertDatabaseHas('task_statuses', $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
    }

    public function testStoreValidatesNameRequired()
    {
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), ['name' => '']);
        $response->assertSessionHasErrors('name');
    }

    public function testEditReturnsEditPage()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $status));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.edit');
    }

    public function testUpdateModifiesStatus()
    {
        $status = TaskStatus::factory()->create(['name' => 'Old Name']);
        $newData = ['name' => 'New Name'];

        $response = $this->actingAs($this->user)->put(route('task_statuses.update', $status), $newData);

        $this->assertDatabaseHas('task_statuses', $newData);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
    }

    public function testGuestCannotAccessStatuses()
    {
        $response = $this->get(route('task_statuses.create'));
        //$response->assertRedirect(route('index'));
        $response->assertStatus(403);
    }
}
