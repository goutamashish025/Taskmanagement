<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('tasks.index');  // Redirect to the tasks index route
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('tasks', TaskController::class);

// Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
});


require __DIR__ . '/auth.php';
