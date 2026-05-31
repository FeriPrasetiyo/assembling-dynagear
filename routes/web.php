<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostFileController;
use App\Http\Controllers\WilayahController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:web')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/wilayah', [WilayahController::class, 'index']);
    Route::get('/wilayah/create', [WilayahController::class, 'create']);
    Route::post('/wilayah', [WilayahController::class, 'store']);
    Route::delete('/wilayah/{wilayah}', [WilayahController::class, 'destroy']);

    Route::get('/wilayah/{wilayah}/foto-video', [PostController::class, 'index']);
    Route::get('/wilayah/{wilayah}/foto-video/create', [PostController::class, 'create']);
    Route::post('/wilayah/{wilayah}/foto-video', [PostController::class, 'store']);

    Route::get('/wilayah/{wilayah}/foto-video/{post}/edit', [PostController::class, 'edit']);
    Route::put('/wilayah/{wilayah}/foto-video/{post}', [PostController::class, 'update']);
    Route::delete('/wilayah/{wilayah}/foto-video/{post}', [PostController::class, 'destroy']);

    Route::get('/wilayah/{wilayah}/foto-video/{post}', [PostController::class, 'show']);
    Route::get('/wilayah/{wilayah}/foto-video/{post}/edit', [PostController::class, 'edit']);
    Route::delete(
    '/wilayah/{wilayah}/foto-video/{post}/file/{file}',
    [PostFileController::class, 'destroy']
);

});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');