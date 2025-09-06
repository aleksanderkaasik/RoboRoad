<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

Route::get('/', [RoboRoadController::class, 'Index']);
Route::get('/stream/{id}', [RoboRoadController::class, 'ViewStream']);
#Route::get('/proxy-stream/{id}', [RoboRoadController::class, 'ProxiedVideoStream']);
Route::get('/info/{id}', [RoboRoadController::class, 'Info']);
Route::get('/system-info/{id}', [RoboRoadController::class, 'SystemInfo']);