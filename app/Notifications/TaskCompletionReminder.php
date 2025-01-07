<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Notifications\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCompletionReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param Task $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];  // You can add more channels as needed
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Task Completion Reminder')
                    ->line('The task "' . $this->task->title . '" is due soon.')
                    ->action('View Task', route('tasks.show', $this->task->id))
                    ->line('Please complete the task before the due date.');
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'due_date' => $this->task->due_date,
            'message' => 'The task "' . $this->task->title . '" is due soon. Please complete it.'
        ];
    }
}
