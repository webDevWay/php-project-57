<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
        $this->user = User::factory()->create();
    }

    public function testGuestCannotAccessLabels()
    {
        $response = $this->get(route('labels.create'));
        $response->assertStatus(403);
    }

    public function testAuthenticatedUserCanViewLabels()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.index'));

        $response->assertStatus(200);
        $response->assertViewIs('labels.index');
    }

    public function testAuthenticatedUserCanCreatelabel()
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

    public function testLabelNameMustBeUnique()
    {
        Label::create(['name' => 'Duplicate']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => 'Duplicate']);

        $response->assertSessionHasErrors('name');
    }

    public function testAuthenticatedUserCanUpdateLabel()
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

    public function testAuthenticatedUserCanDeleteLabelWithoutTasks()
    {
        $label = Label::create(['name' => 'Deletable']);

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testCannotDeleteLabelWithAssociatedTasks()
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

    public function testValidationRequiredName()
    {
        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => '']);

        $response->assertSessionHasErrors('name');
    }
}
