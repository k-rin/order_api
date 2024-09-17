<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::post('/', [ OrderController::class, 'store' ]);
    Route::get('/{id}', [ OrderController::class, 'show' ]);
});
