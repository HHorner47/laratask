<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskReminder;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予定時刻が近いタスクのメール送信';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Task::with('user')
            ->whereNull('reminded_at')
            ->whereBetween('scheduled_at', [now(), now()->addMinutes(30)])
            ->whereDoesntHave('completed')
            ->get()
            ->each(function (Task $task) {
                $task->user->notify(new TaskReminder($task));
                $task->forceFill(['reminded_at' => now()])->save();
            });
    }
}
