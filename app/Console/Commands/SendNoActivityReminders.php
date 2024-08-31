<?php

namespace App\Console\Commands;

use App\Mail\NoActivityReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // Ensure you include the User model

class SendNoActivityReminders extends Command
{
    protected $signature = 'reminders:no-activity';
    protected $description = 'Send inactivity reminder emails to users who have been inactive for 3 days';

    public function handle()
    {
        // Fetch users who have been inactive for 3 days
        $users = User::where('last_activity', '<', now()->subDays(3))->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NoActivityReminder($user->name));
            $this->info("Sent reminder to {$user->name}");
        }

        $this->info('Inactivity reminders sent successfully.');
    }
}
