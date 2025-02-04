<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('translations/cache', [TranslationController::class, 'getTranslations']);
    Route::apiResource('translations', TranslationController::class)->except(['show']);
    Route::get('translations/export', [TranslationController::class, 'export']);
});
Route::post('login', [AuthController::class, 'login']);


