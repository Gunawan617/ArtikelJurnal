<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/articles/{slug}/comments', [ArticleController::class, 'comments']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/articles/{slug}/comment', [CommentController::class, 'store']);
    Route::post('/comments/{id}/reply', [CommentController::class, 'reply']);
});
