<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/movies', [GenreController::class, 'index'])->name('movies.index');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::get('/movies/trash', [MovieController::class, 'trash'])->name('movies.trash');
    Route::delete('/movies/{id}', [MovieController::class, 'destroy'])->name('movies.destroy');
    Route::post('/movies/{id}/restore', [MovieController::class, 'restore'])->name('movies.restore');
    Route::resource('movies', MovieController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
    Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
    Route::get('/genres/{genre}/edit', [GenreController::class, 'edit'])->name('genres.edit');
    Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
    Route::get('/genres/trash', [GenreController::class, 'trash'])->name('genres.trash');
    Route::delete('/genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');
    Route::post('/genres/{id}/restore', [GenreController::class, 'restore'])->name('genres.restore');
    Route::resource('genres', GenreController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
