<?php

use App\Http\Controllers\SoundPackController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SoundPackController::class, 'index'])->name('sound_pack.index');
Route::post('/', [SoundPackController::class, 'store'])->name('sound_pack.store');

Route::get('/{sound_pack}', [SoundPackController::class, 'show'])->name('sound_pack.show');
Route::post('/{sound_pack}', [SoundPackController::class, 'update'])->name('sound_pack.update');
Route::delete('/{sound_pack}', [SoundPackController::class, 'destroy'])->name('sound_pack.destroy');
