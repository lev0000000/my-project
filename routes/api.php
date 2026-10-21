<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('authors')->group(function () {
    Route::get('/slug/{slug}', [
        AuthorController::class,
        'showBySlug',
    ]);

    Route::get('/{author}', [
        AuthorController::class,
        'show',
    ])->whereNumber('author');
});
