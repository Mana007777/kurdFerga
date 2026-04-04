<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promotes a specific user to an admin role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email {$email} not found.");

            return Command::FAILURE;
        }

        $user->update(['role' => 'admin']);
        $this->info("User {$user->name} ({$user->email}) is now an admin.");

        return Command::SUCCESS;
    }
}
