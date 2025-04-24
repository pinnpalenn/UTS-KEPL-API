<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;

Route::get('/', [CurrencyController::class, 'index'])->name('currency.index');
Route::post('/convert', [CurrencyController::class, 'convert'])->name('currency.convert');
Route::get('/convert', [CurrencyController::class, 'index']);
