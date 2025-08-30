<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoStreamingController;

Route::get('/', [VideoStreamingController::class, 'Index']);
Route::get('/stream/{id}', [VideoStreamingController::class, 'ViewStream']);
Route::get('/proxy-stream/{id}', [VideoStreamingController::class, 'ProxiedVideoStream']);