<?php

use App\Http\Controllers\PopupAnalyticController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\PopupLayoutTypeController;
use App\Http\Controllers\PopupScheduleController;
use App\Http\Controllers\PopupTypeController;
use App\Http\Controllers\PopupVariantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::apiResources([
    'popup_layout_types' => PopupLayoutTypeController::class,
    'popup_types' => PopupTypeController::class,
    'popup_variants' => PopupVariantController::class,
    'popup_schedules' => PopupScheduleController::class
]);

Route::prefix('popups')->group(function () {
    Route::resource('/', PopupController::class);

    Route::post('/{type}', [PopupController::class, 'getPopups']);
    Route::get('{id}/variants', [PopupVariantController::class, 'index'])->name('popupVariants');
    Route::get('{id}/variants/{id}/schedules', [PopupScheduleController::class, 'index'])->name('popupSchedules');
    Route::get('{id}/analytics', [PopupAnalyticController::class, 'showByPopupId'])->name('popupAnalytics');
});

Route::prefix('popup-analytic')->group(function () {
    Route::get('/view', [PopupAnalyticController::class, 'addView'])->name('popup-analytic.addView');
    Route::get('/click', [PopupAnalyticController::class, 'addClick'])->name('popup-analytic.addClick');
    Route::get('/conversion', [PopupAnalyticController::class, 'addConversion'])->name('popup-analytic.addConversion');
});

Route::get('analytics', [PopupAnalyticController::class, 'topAnalytics'])->name('analytics');
