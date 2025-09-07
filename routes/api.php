<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

#Route::get('/nodes/{id}/proxy-stream/', [RoboRoadController::class, 'getProxiedStream'])->name('nodes.proxystream');
Route::get('/nodes/{id}/system-info', [RoboRoadController::class, 'getNodeSystemInfo'])->name('nodes.system-info');
Route::post('/nodes', [RoboRoadController::class, 'createNode'])->name('nodes.creation');
Route::delete('/nodes/{id}', [RoboRoadController::class, 'deleteNode'])->name('nodes.deletion');
Route::patch('/nodes/{id}', [RoboRoadController::class, 'updateNode'])->name('nodes.modifying');