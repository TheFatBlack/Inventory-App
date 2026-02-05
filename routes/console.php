<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('roles:fix-petugas', function () {
    $affected = DB::update("
        UPDATE users u
        JOIN petugas p ON p.user_id = u.id
        SET u.role = 'petugas'
        WHERE u.role != 'petugas'
    ");

    $this->info('Roles updated for petugas-linked users: ' . $affected);
})->purpose('Fix users.role to petugas for users linked in petugas table');
