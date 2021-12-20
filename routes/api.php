<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;


Route::prefix('usuario')->group(function () {
    Route::get('/',[ UsuarioController::class, 'getAll']);
    Route::post('/',[ UsuarioController::class, 'create']);
    Route::delete('/{id}',[ UsuarioController::class, 'delete']);
    Route::get('/{id}',[ UsuarioController::class, 'get']);
    Route::put('/{id}',[ UsuarioController::class, 'update']);
});