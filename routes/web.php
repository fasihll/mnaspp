<?php

use App\Livewire\Admin\Departement;
use App\Livewire\Admin\Transaction;
use App\Livewire\Admin\Users;
use App\Livewire\Student\Biodata;
use App\Livewire\Student\Dashboard;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::middleware('admin')->group(function () {
        Route::get('departement', Departement::class)->name('admin.departement');
        Route::get('transaction', Transaction::class)->name('admin.transaction');
        Route::get('users', Users::class)->name('admin.users');
    });

    Route::middleware('student')->group(function () {
        Route::get('dashboard', Dashboard::class)->name('student.dashboard');
        Route::get('biodata', Biodata::class)->name('student.biodata');
    });
});

require __DIR__ . '/auth.php';
