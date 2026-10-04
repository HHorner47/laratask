<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TaskCompleteController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::post('/tasks/{task}/complete', [TaskCompleteController::class, 'store'])->name('tasks.complete');
    Route::delete('/tasks/{task}/complete', [TaskCompleteController::class, 'destroy'])->name('tasks.not_completed');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
