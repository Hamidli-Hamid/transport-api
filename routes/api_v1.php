<?php

use App\Http\Controllers\Api\TransportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.basic')->group(function () {
    Route::post('/calculate-price', [TransportController::class, 'calculatePrice']);
});
