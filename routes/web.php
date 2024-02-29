<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/404', fn () => ['oi']);
Route::get('/403', function () {
    abort_if(true, 403);

    return ['oi'];
});
