<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Company;

use Illuminate\Support\Facades\Schedule;



$absenceTime = Company::value('AbsenceTime') ?? '12:00';
$schedule->command('app:mark-as-absent')->dailyAt($absenceTime);
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
