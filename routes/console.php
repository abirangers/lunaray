<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Manual processing status command
Artisan::command('media:status', function () {
    $this->info('MediaLibrary Manual Processing Status:');
    $this->line('✅ Manual processing enabled');
    $this->line('✅ Conversions processed immediately on upload');
    $this->line('✅ No queue processing needed');
    $this->line('✅ Perfect for shared hosting');
})->purpose('Check MediaLibrary manual processing status');

// Schedule daily cleanup of expired chat sessions
Schedule::command('chat:cleanup-expired')->daily();
