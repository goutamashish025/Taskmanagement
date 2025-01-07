<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskCompletionReminder;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendTaskCompletionReminders extends Command
{
    protected $signature = 'task:reminder';
    protected $description = 'Send task completion reminders to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tasks = Task::where('status', '!=', 'completed')
            ->where('due_date', '>', Carbon::now())
            ->where('due_date', '<', Carbon::now()->addDays(1))  // Tasks due in the next 24 hours
            ->get();

        foreach ($tasks as $task) {
            // Send notification to the user
            $task->user->notify(new TaskCompletionReminder($task));
        }

        $this->info('Task completion reminders have been sent.');
    }
}
