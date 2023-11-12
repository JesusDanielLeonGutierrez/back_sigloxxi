<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/doctores', [DoctoresController::class, 'index']);
    Route::post('/doctores/crear', [DoctoresController::class, 'store']);
    Route::patch('/doctores/{id}/update', [DoctoresController::class, 'update']);
    Route::delete('/doctores/{id}', [DoctoresController::class, 'destroy']);

    Route::get('/citas', [CitasController::class, 'index']);
    Route::post('/citas/crear', [CitasController::class, 'store']);
    Route::patch('/citas/{id}/update', [CitasController::class, 'update']);
    Route::delete('/citas/{id}', [CitasController::class, 'destroy']);

    Route::get('/pacientes', [PacientesController::class, 'index']);
    Route::post('/pacientes/crear', [PacientesController::class, 'store']);

    Route::post('/encuesta', [FormularioController::class, 'store']);
    Route::get('/encuesta/check', [FormularioController::class, 'index']);
});
