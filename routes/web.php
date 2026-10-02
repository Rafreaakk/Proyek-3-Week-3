<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

// Route::get('/activities', [ActivityController::class, 'index'])
//     ->name('activities.index');

// Route::get('/activities/{activity}', [ActivityController::class, 'show'])
//     ->name('activities.show');
Route::get('/activities/trash', [App\Http\Controllers\ActivityController::class, 'trash'])->name('activities.trash');
Route::post('/activities/{id}/restore', [App\Http\Controllers\ActivityController::class, 'restore'])->name('activities.restore');

Route::resource('activities', ActivityController::class);
Route::post('/activities/{id}/register', [App\Http\Controllers\RegistrationController::class, 'store'])->name('registrations.store');