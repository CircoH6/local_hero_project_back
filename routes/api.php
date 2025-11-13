<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentficatedController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\RecommandationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post("/register",[AuthentficatedController::class, "register"]);
Route::post("/login",[AuthentficatedController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    // Prestataires
    Route::apiResource('prestataires', PrestataireController::class);

    // Avis
    Route::apiResource('avis', AvisController::class)->except(['update']);

    // Recommandations
    Route::apiResource('recommandations', RecommandationController::class)->only(['store', 'index', 'destroy']);
});
