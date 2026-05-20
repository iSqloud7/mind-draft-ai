<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login.
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Main dashboard route.
Route::get('/dashboard', [PresentationController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Protected routes requiring authentication.
Route::middleware(['auth'])->group(function () {

    // User profile management.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Standard CRUD for workspaces.
    Route::resource('workspaces', WorkspaceController::class);
    Route::get('/workspaces', [WorkspaceController::class, 'index'])->name('workspaces.index');

    // Presentation management routes.
    Route::get('/presentations', [PresentationController::class, 'index'])->name('presentations.index');
    Route::get('/presentations/create', [PresentationController::class, 'create'])->name('presentations.create');
    Route::post('/presentations', [PresentationController::class, 'store'])->name('presentations.store');
    Route::get('/presentations/{presentation}', [PresentationController::class, 'show'])->name('presentations.show');
    Route::get('/presentations/{presentation}/edit', [PresentationController::class, 'edit'])->name('presentations.edit');
    Route::put('/presentations/{presentation}', [PresentationController::class, 'update'])->name('presentations.update');
    Route::delete('/presentations/{presentation}', [PresentationController::class, 'destroy'])->name('presentations.destroy');

    // AI actions, presentation mode, and export.
    Route::post('/presentations/{id}/regenerate-slide/{index}', [PresentationController::class, 'regenerateSlide']);
    Route::get('/presentations/{id}/present', [PresentationController::class, 'present'])->name('presentations.present');
    Route::get('/presentations/{id}/export-pdf', [PresentationController::class, 'exportPdf'])->name('presentations.export-pdf');

    // Organize presentations into workspaces.
    Route::patch('/presentations/{presentation}/workspace', [PresentationController::class, 'updateWorkspace'])->name('presentations.updateWorkspace');
});

// Load default authentication routes
require __DIR__ . '/auth.php';
