<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Company;

use Illuminate\Support\Facades\Schedule;



Schedule::command('pointage:mark-absents')
    ->dailyAt(Company::value('absenceTime') ?? '12:00');
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
