<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoStreamingController;

Route::get('/stream', [VideoStreamingController::class, 'ViewStream']);
Route::get('/proxy-stream', [VideoStreamingController::class, 'ProxiedVideoStream']);