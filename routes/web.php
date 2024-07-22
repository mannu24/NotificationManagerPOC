<?php

use App\Livewire\Admin\NotificationsList;
use App\Livewire\Admin\UsersList;
use App\Livewire\User\UserDashboard;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');
Auth::routes();

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users', UsersList::class)->name('users');
    Route::get('/notifications', NotificationsList::class)->name('notifications');
});

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('{user}', UserDashboard::class)->name('user.home');
});
