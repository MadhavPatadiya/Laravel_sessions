<?php

use App\Http\Controllers\Admin\FormController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'index']);
Route::post('/add-to-session', [FormController::class, 'addToSession'])->name('add.to.session');
Route::get('/dump-session-data', [FormController::class, 'dumpSessionData'])->name('dump.session.data');
Route::delete('/remove-session-data/{index}', [FormController::class, 'removeFromSession'])->name('remove.session.data');
Route::post('/submit-session-data', [FormController::class, 'submitSessionData'])->name('submit.session.data');

// Route::get('/', function () {
//     return view('welcome');
// });
