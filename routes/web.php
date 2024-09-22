<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


Route::post('/task/created', [TaskController::class, 'store'])->name('task.store');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// Rota para exibir o formulário de atualização
Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');

// Rota para atualizar o status da task
Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');



Route::get('/', function () {
    return view('task.form');
});