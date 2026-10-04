<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskCompleteTest extends TestCase
{
      use RefreshDatabase;
    /**
     * A basic feature test example.
     */
  public function test_allows_a_user_to_complete_a_task(): void
  {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    $this->actingAs($user)
      ->post(route('tasks.complete', ['task' => $task->id]))
      ->assertStatus(302);

    $this->assertDatabaseHas('task_user', [
      'user_id' => $user->id,
      'task_id' => $task->id
    ]);
  }
    public function test_allows_a_user_to_cancel_a_complete_task(): void
  {
    $user = User::factory()->create();
    $task = Task::factory()->create();


    $user->completes()->attach($task);

    $this->actingAs($user)
      ->delete(route('tasks.not_completed', ['task' => $task->id]))
      ->assertStatus(302);

    $this->assertDatabaseMissing('task_user', [
      'user_id' => $user->id,
      'task_id' => $task->id
    ]);
    }
}
