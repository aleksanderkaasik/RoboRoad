<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

#Route::get('/proxy-stream/{id}', [RoboRoadController::class, 'ProxiedVideoStream'])->name('nodes.proxystream');
Route::get('/info/{id}', [RoboRoadController::class, 'Info'])->name('nodes.info');
Route::get('/system-info/{id}', [RoboRoadController::class, 'SystemInfo'])->name('nodes.system.info');