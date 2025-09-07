<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

Route::get('/', [RoboRoadController::class, 'Index'])->name('nodes.menu');
Route::get('/stream/{id}', [RoboRoadController::class, 'ViewStream'])->name('nodes.preview');