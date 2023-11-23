<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::get('/employee/{id}', [EmployeeController::class, 'show']);
    Route::post('/employee', [EmployeeController::class, 'store']);
    Route::put('/employee/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy']);


    Route::get('/worker', [EmployeeController::class, 'indexWorker']);
    Route::post('/worker', [EmployeeController::class, 'storeWorker']);


});

Route::get('/nation', [EmployeeController::class, 'getNations']);
Route::get('/stats', [EmployeeController::class, 'getStats']);
Route::get('/prefecture', [EmployeeController::class, 'getPrefecture']);
Route::get('/work_place', [EmployeeController::class, 'getWorkPlace']);

Route::post('/login', [AuthController::class, 'login']);
