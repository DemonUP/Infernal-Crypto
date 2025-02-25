<?php
use App\Http\Controllers\CryptoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CryptoController::class, 'index']);
Route::get('/api/cryptos', [CryptoController::class, 'getCryptos']);

