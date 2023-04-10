<?php

use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
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

Route::apiResource('/user',App\Http\Controllers\UserController::class);
Route::apiResource('/transaction',App\Http\Controllers\TransactionController::class);
Route::post('/transaction/cleaner',[TransactionController::class,'checkingAndCleaner']);
Route::post('/transaction/checkingTransaction',[TransactionController::class,'checkingTransaction']);
Route::post('/transaction/CreateTrigger',[TransactionController::class,'createTrigger']);
Route::post('/transaction/DeleteTrigger',[TransactionController::class,'deleteTrigger']);
Route::post('/actualizar-estatus', 'App\Http\Controllers\GlobalVariableController@actualizarEstatus');