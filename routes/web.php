<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'getVersion']);

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

Route::middleware('auth:web')->controller(SubscriberController::class)
    ->group(function () {
        Route::get('subscribers', [SubscriberController::class, 'index']);
    });

Route::middleware('auth:web')->controller(ArticleController::class)
    ->group(function () {
        Route::resources([
            'articles' => ArticleController::class
        ], ['except' => ['create', 'edit']]);
    });

Route::middleware('auth:web')->controller(ArticleCategoryController::class)
    ->group(function () {
        Route::get('article-categories', [ArticleCategoryController::class, 'index']);
    });


    