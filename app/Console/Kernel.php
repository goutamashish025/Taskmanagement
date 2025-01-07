<?php

namespace App\Console;

use App\Console\Commands\SendTaskCompletionReminders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The application's command schedule.
     *
     * @var \Illuminate\Console\Scheduling\Schedule
     */
    protected $schedule;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule the task reminder command to run daily at midnight
        $schedule->command('task:reminder')->daily(); // Runs every day at midnight

        // You can also add more commands to be scheduled here
        // For example, to clear the cache every day at 2 AM:
        // $schedule->command('cache:clear')->dailyAt('2:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Register the default set of commands provided by Laravel
        $this->load(__DIR__.'/Commands');

        // Register the custom SendTaskCompletionReminders command
        $this->command(SendTaskCompletionReminders::class);

        // Register any other commands here
        // For example, you can add custom artisan commands that should be available
        // $this->load(__DIR__.'/AnotherCustomCommand.php');

        // Load the routes for Artisan commands
        require base_path('routes/console.php');
    }
}

