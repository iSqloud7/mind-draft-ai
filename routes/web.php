<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresentationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/presentations/create', [PresentationController::class, 'create'])->name('presentations.create');
Route::get('/presentations/{id}', [PresentationController::class, 'show'])->name('presentations.show');
Route::get('/presentations', [PresentationController::class, 'index'])->name('presentations.index');
Route::post('/presentations', [PresentationController::class, 'store'])->name('presentations.store');

