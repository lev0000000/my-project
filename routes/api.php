<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('authors')
    ->controller(AuthorController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/slug/{slug}', 'showBySlug');
        Route::get('/{author}', 'show');
    });

Route::prefix('categories')
    ->controller(CategoryController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/tree', 'tree');
        Route::get('/slug/{slug}', 'showBySlug');
        Route::get('/{category}', 'show');
    });

Route::prefix('articles')
    ->controller(ArticleController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/slug/{slug}', 'showBySlug');
        Route::get('/{article}', 'show');
    });
