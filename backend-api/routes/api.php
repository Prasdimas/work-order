<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderProgressController;

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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('work-order/getProgressData', [AuthController::class, 'getProgressData']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/operators', [AuthController::class, 'getAllUsers']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('work-order/create', [WorkOrderController::class, 'create']);
    Route::post('work-order/save', [WorkOrderController::class, 'save']);
    Route::post('work-order/delete', [WorkOrderController::class, 'delete']);
    Route::put('work-order/update/{id}', [WorkOrderController::class, 'updateStatus']);
    Route::get('work-orders', [WorkOrderController::class, 'listWorkOrders']);
    Route::get('operator-work-orders', [WorkOrderProgressController::class, 'listWorkOrders']);

    Route::post('work-order-progress/update/{id}', [WorkOrderProgressController::class, 'updateStatus']);
    Route::get('work-order/work-order-report', [WorkOrderController::class, 'getWorkOrderReport']);
    Route::get('report', [WorkOrderController::class, 'report']);
    Route::get('operator-report', [WorkOrderProgressController::class, 'operatorReport']);
    Route::get('work-order/completed-status-per-user', [WorkOrderController::class, 'getCompletedStatusPerUser']);
});
