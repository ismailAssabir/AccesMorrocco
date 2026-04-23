<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MarkAsAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-as-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // app/Console/Commands/MarkAsAbsent.php


    $today = now()->toDateString();
    
    
    $absentUsers = \App\Models\User::whereDoesntHave('pointages', function($query) use ($today) {
        $query->where('date', $today);
    })->get();

    foreach ($absentUsers as $user) {
        \App\Models\Pointage::create([
            'idUser' => $user->id,
            'date'   => $today,
            'status' => 'absent',
            
        ]);
    }
}
    }

