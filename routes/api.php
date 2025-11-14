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

    //Vérifier le user connecté
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // pour prestataires
    Route::prefix('/prestataires')->group(function () {
        Route::get('/index', [PrestataireController::class, 'index']);
        Route::post('/store', [PrestataireController::class, 'store']);
        Route::get('/show/{id}', [PrestataireController::class, 'show']);
        Route::put('/update/{id}', [PrestataireController::class, 'update']);
        Route::delete('/destroy/{id}', [PrestataireController::class, 'destroy']);
    });

    // pour avis
    Route::prefix('/avis')->group(function () {
        Route::get('/index', [AvisController::class, 'index']);
        Route::post('/store/{id}', [AvisController::class, 'store']);
        Route::get('/show/{id}', [AvisController::class, 'show']);
        Route::delete('/destroy/{id}', [AvisController::class, 'destroy']);
    });

    // pour recommandations
    Route::prefix('/recommandations')->group(function () {
        Route::get('/index', [RecommandationController::class, 'index']);
        Route::post('/store', [RecommandationController::class, 'store']);
        Route::delete('/destroy/{id}', [RecommandationController::class, 'destroy']);
    });

});
