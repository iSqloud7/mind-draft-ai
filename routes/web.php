<?php

use App\Http\Controllers\PresentationController;

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [PresentationController::class, 'index'])->name('dashboard');
    Route::get('/presentations', [PresentationController::class, 'index']);

    Route::get('/presentations/create', [PresentationController::class, 'create'])->name('presentations.create');
    Route::post('/presentations', [PresentationController::class, 'store'])->name('presentations.store');

    Route::get('/presentations/{presentation}', [PresentationController::class, 'show'])->name('presentations.show');

    Route::get('/presentations/{presentation}/edit', [PresentationController::class, 'edit'])->name('presentations.edit');
    Route::put('/presentations/{presentation}', [PresentationController::class, 'update'])->name('presentations.update');

    Route::delete('/presentations/{presentation}', [PresentationController::class, 'destroy'])->name('presentations.destroy');

    Route::post('/presentations/{id}/regenerate-slide/{index}', [PresentationController::class, 'regenerateSlide']);

    Route::get('/presentations/{id}/export-pdf', [PresentationController::class, 'exportPdf']);

    Route::get('/presentations/{id}/present', [PresentationController::class, 'present']);
});
