<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

// Route::apiResource('/user',App\Http\Controllers\UserController::class);
Route::controller(UserController::class)->group(function(){
    Route::get('/user','index');
    Route::post('/user', 'store') ;
    Route::get('/user/{user}', 'show');
    Route::put('/user/{user}', 'update');
    Route::delete('/user/{user}', 'destroy');
});

// Route::apiResource('/transaction',App\Http\Controllers\TransactionController::class);

Route::controller(TransactionController::class)->group(function(){
    Route::get('/transaction','index');
    Route::post('/transaction', 'store') ;
    Route::get('/transaction/{transaction}', 'show');
    Route::put('/transaction/{transaction}', 'update');
    Route::delete('/transaction/{transaction}', 'destroy');
    Route::get('/mostrarSumaDepositosYSaldos', [TransactionController::class, 'mostrarSumaDepositosYSaldos']);
});

Route::post('/transaction/cleaner',[TransactionController::class,'checkingAndCleaner']);
Route::post('/transaction/checkingTransaction',[TransactionController::class,'checkingTransaction']);
Route::post('/transaction/CreateTrigger',[TransactionController::class,'createTrigger']);
Route::post('/transaction/DeleteTrigger',[TransactionController::class,'deleteTrigger']);
Route::post('/actualizar-estatus', 'App\Http\Controllers\GlobalVariableController@actualizarEstatus');

