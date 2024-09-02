<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateSanctumToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanctum:generate-token {admin_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Sanctum token for the specified user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = Admin::find($this->argument('admin_id'));

        if (!$admin) {
            $this->error('User not found!');
        }

        // Create a new token
        $token = $admin->createToken('Personal Access Token')->plainTextToken;

        $this->info('Token generated successfully!');
        $this->info('Token: ' . $token);
    }
}
