<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('/admin');
});

// Temporary route to clear cache - remove after use
Route::get('/clear-cache-now', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    
    return 'Cache cleared successfully! You can now refresh your dashboard.';
});
