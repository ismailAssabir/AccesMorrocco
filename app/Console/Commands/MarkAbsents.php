<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pointage;
use Carbon\Carbon;

class MarkAbsents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pointage:mark-absents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Identify and record absences for active employees/managers who haven\'t clocked in.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automated absence marking task...');

        $today = Carbon::today()->toDateString();
        
        // 1. Get ONLY ACTIVE users who are NOT admins
        $usersToMonitor = User::where('type', '!=', 'admin')
            ->where('status', 'active')
            ->get();
        
        $count = 0;
        foreach ($usersToMonitor as $user) {
            // 2. Check if they already have a record for today
            $exists = Pointage::where('idUser', $user->idUser)
                ->where('date', $today)
                ->exists();
                
            if (!$exists) {
                // 3. Create absent record
                Pointage::create([
                    'idUser' => $user->idUser,
                    'date'   => $today,
                    'status' => 'absent',
                ]);
                $count++;
                $this->line("Marked {$user->firstName} {$user->lastName} (ID: {$user->idUser}) as absent.");
            }
        }

        $this->info("Task completed. {$count} users marked as absent for {$today}.");
    }
}
