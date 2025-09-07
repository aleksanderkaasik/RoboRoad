<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

#Route::get('/nodes/{id}/proxy-stream/', [RoboRoadController::class, 'ProxiedVideoStream'])->name('nodes.proxystream');
Route::get('/nodes/{id}/system-info', [RoboRoadController::class, 'SystemInfo'])->name('nodes.system-info');
Route::post('/nodes', [RoboRoadController::class, 'NodeCreating'])->name('nodes.creation');