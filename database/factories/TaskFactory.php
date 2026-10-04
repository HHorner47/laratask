<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
      protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'user_id' => User::factory(), // UserモデルのFactoryを使用してユーザを生成
                'task' => $this->faker->text(200), // ダミーのテキストデータ
                'scheduled_at' => fake()->dateTimeBetween('+1 hour', '+1 week'),
        ];
    }
      public function test_displays_the_create_task_page(): void
  {
    // テスト用のユーザーを作成
    $user = User::factory()->create();

    // ユーザーを認証（ログイン）
    $this->actingAs($user);

    // 作成画面にアクセス
    $response = $this->get('/tasks/create');

    // ステータスコードが200であることを確認
    $response->assertStatus(200);
  }
    // 作成処理のテスト
  public function test_allows_authenticated_users_to_create_a_task(): void
  {
    // ユーザを作成
    $user = User::factory()->create();

    // ユーザを認証
    $this->actingAs($user);

    // Tweetを作成
    $taskData = ['task' => 'This is a test tweet.'];

    // POSTリクエスト
    $response = $this->post('/tasks', $taskData);

    // データベースに保存されたことを確認
    $this->assertDatabaseHas('tasks', $taskData);

    // レスポンスの確認
    $response->assertStatus(302);
    $response->assertRedirect('/tasks');
  }
    // 詳細画面のテスト
  public function test_displays_a_task(): void
  {
    // ユーザを作成
    $user = User::factory()->create();

    // ユーザを認証
    $this->actingAs($user);

    // Tweetを作成
    $task = Task::factory()->create();

    // GETリクエスト
    $response = $this->get("/tasks/{$task->id}");

    // レスポンスにTweetの内容・日時・投稿者名が含まれていることを確認
    $response->assertStatus(200);
    $response->assertSee($task->task);
    $response->assertSee($task->created_at->format('Y-m-d H:i'));
    $response->assertSee($task->updated_at->format('Y-m-d H:i'));
    $response->assertSee($task->user->name);
  }
    // 編集画面のテスト
  public function test_displays_the_edit_task_page(): void
  {
    // テスト用のユーザーを作成
    $user = User::factory()->create();

    // ユーザーを認証（ログイン）
    $this->actingAs($user);

    // Tweetを作成
    $task = Task::factory()->create(['user_id' => $user->id]);

    // 編集画面にアクセス
    $response = $this->get("/tasks/{$task->id}/edit");

    // ステータスコードが200であることを確認
    $response->assertStatus(200);

    // ビューにTweetの内容が含まれていることを確認
    $response->assertSee($task->task);
  }
    // 更新処理のテスト
  public function test_allows_a_user_to_update_their_task(): void
  {
    // ユーザを作成
    $user = User::factory()->create();

    // ユーザを認証
    $this->actingAs($user);

    // Tweetを作成
    $task = Task::factory()->create(['user_id' => $user->id]);

    // 更新データ
    $updatedData = ['task' => 'Updated task content.'];

    // PUTリクエスト
    $response = $this->put("/tasks/{$task->id}", $updatedData);

    // データベースが更新されたことを確認
    $this->assertDatabaseHas('tasks', $updatedData);

    // レスポンスの確認
    $response->assertStatus(302);
    $response->assertRedirect("/tasks/{$task->id}");
  }
    // 削除処理のテスト
  public function test_allows_a_user_to_delete_their_task(): void
  {
    // ユーザを作成
    $user = User::factory()->create();

    // ユーザを認証
    $this->actingAs($user);

    // Tweetを作成
    $task = Task::factory()->create(['user_id' => $user->id]);

    // DELETEリクエスト
    $response = $this->delete("/tasks/{$task->id}");

    // データベースから削除されたことを確認
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

    // レスポンスの確認
    $response->assertStatus(302);
    $response->assertRedirect('/tasks');
  }
}
