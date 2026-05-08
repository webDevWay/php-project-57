<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guest_cannot_access_labels()
    {
        $response = $this->get(route('labels.create'));
        $response->assertRedirect(route('index'));
    }

    public function test_authenticated_user_can_view_labels()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.index'));

        $response->assertStatus(200);
        $response->assertViewIs('labels.index');
    }

    public function test_authenticated_user_can_createlabel()
    {
        $data = [
            'name' => 'Bug',
            'description' => 'Something is broken',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
    }

    public function test_label_name_must_be_unique()
    {
        Label::create(['name' => 'Duplicate']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => 'Duplicate']);

        $response->assertSessionHasErrors('name');
    }

    public function test_authenticated_user_can_update_label()
    {
        $label = Label::create(['name' => 'Old Name']);

        $response = $this->actingAs($this->user)
            ->put(route('labels.update', $label), [
                'name' => 'New Name',
                'description' => 'New Description',
            ]);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $label->id, 'name' => 'New Name']);
    }

    public function test_authenticated_user_can_delete_label_without_tasks()
    {
        $label = Label::create(['name' => 'Deletable']);

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function test_cannot_delete_label_with_associated_tasks()
    {
        $label = Label::create(['name' => 'Protected']);
        $task = Task::factory()->create();
        $task->labels()->attach($label);

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function test_validation_required_name()
    {
        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => '']);

        $response->assertSessionHasErrors('name');
    }
}
