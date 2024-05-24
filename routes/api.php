<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::group(['prefix' => 'note'], function () {
    Route::get('/',  [NoteController::class, 'index'])->name('note.index');
    
    Route::get('/{id}', [NoteController::class, 'show'])->name('note.show');

    Route::post('/', [NoteController::class, 'store'])->name('note.store');
    
    Route::put('/{id}', [NoteController::class, 'update'])->name('note.update');
    
    Route::delete('/{id}',[NoteController::class, 'destroy'])->name('note.destroy');
});