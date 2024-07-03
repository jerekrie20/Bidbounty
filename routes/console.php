<?php

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('queue:prune {--hours=24}', function () {
    $hours = $this->option('hours');

    DB::table('jobs')
        ->where('created_at', '<', Carbon::now()->subHours($hours))
        ->delete();

    $this->info('Processed jobs older than ' . $hours . ' hours have been pruned.');
})->describe('Prune processed jobs from the queue')->daily();

Artisan::command('telescope:prune {--hours=24}', function () {
    $hours = $this->option('hours');

    DB::table('telescope_entries')
        ->where('created_at', '<', Carbon::now()->subHours($hours))
        ->delete();

    $this->info('Telescope entries older than ' . $hours . ' hours have been pruned.');
})->describe('Prune old Telescope entries')->daily();

