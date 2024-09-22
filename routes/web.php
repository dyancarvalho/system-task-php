<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('task.form');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');

Route::post('/task/created', [TaskController::class, 'store'])->name('task.store');

Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');



