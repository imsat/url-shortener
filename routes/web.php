<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/r/{shortUrl}', [UrlController::class, 'redirect']);

Route::get('{path}', function () {
    return view('app');
})->where('path', '([A-z\d\-\/_.]+)?');


