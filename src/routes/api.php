<?php

use Illuminate\Support\Facades\Route;
use Molitor\Setting\Http\Controllers\Api\SettingApiController;

Route::prefix('api/setting')->middleware(['api', 'auth:sanctum'])->group(function () {
    Route::get('/', [SettingApiController::class, 'index'])->name('setting.api.index');
    Route::get('/{slug}', [SettingApiController::class, 'show'])->name('setting.api.show');
    Route::post('/{slug}', [SettingApiController::class, 'update'])->name('setting.api.update');
});
