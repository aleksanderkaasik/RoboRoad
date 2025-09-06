<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoStreamingController;

Route::get('/', [VideoStreamingController::class, 'Index']);
Route::get('/stream/{id}', [VideoStreamingController::class, 'ViewStream']);
#Route::get('/proxy-stream/{id}', [VideoStreamingController::class, 'ProxiedVideoStream']);
Route::get('/info/{id}', [VideoStreamingController::class, 'Info']);
Route::get('/system-info/{id}', [VideoStreamingController::class, 'SystemInfo']);