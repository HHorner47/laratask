<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

  public function test_displays_tasks(): void
  {
    // ユーザを作成
    $user = User::factory()->create();

    // ユーザを認証
    $this->actingAs($user);

    // Taskを作成
    $task = Task::factory()->create();

    // GETリクエスト
    $response = $this->get('/tasks');

    // レスポンスにTweetの内容と投稿者名が含まれていることを確認
    $response->assertStatus(200);
    $response->assertSee($task->task);
    $response->assertSee($task->user->name);
  }
}
