<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoboRoadController;

Route::get('/', [RoboRoadController::class, 'Index'])->name('nodes.index');
Route::get('/nodes/{id}/stream', [RoboRoadController::class, 'getStreamPreviewPage'])->name('nodes.stream');
Route::get('/nodes/{id}/status', [RoboRoadController::class, 'getNodeStatusPage'])->name('nodes.status');
Route::get('/nodes/create', [RoboRoadController::class, 'getCreateNodePage'])->name('nodes.create');
Route::get('/nodes/{id}/confirmation-deletion', [RoboRoadController::class, 'getConfirmationDeletionPage'])->name('nodes.delete');
Route::get('/nodes/{id}/update/', [RoboRoadController::class, 'getEditNodePage'])->name('nodes.update');