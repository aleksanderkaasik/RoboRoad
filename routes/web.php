<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

Route::get('/', [RoboRoadController::class, 'Index'])->name('nodes.index');
Route::get('/nodes/{id}/stream', [RoboRoadController::class, 'ViewStream'])->name('nodes.stream');
Route::get('/nodes/{id}/status', [RoboRoadController::class, 'Info'])->name('nodes.status');
Route::get('/nodes/create', [RoboRoadController::class, 'NodeCreate'])->name('nodes.create');