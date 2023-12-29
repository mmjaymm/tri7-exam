<?php

use App\Http\Controllers\Api\EmployeeController;
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

Route::prefix('employee')->group(function () {
    Route::get('get-all', [EmployeeController::class, 'getAllEmployees'])->name('employee.get-all');
    Route::post('create', [EmployeeController::class, 'storeEmployee'])->name('employee.create');
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
    Route::get('/{id}', [EmployeeController::class, 'show'])->name('employee.edit');
    Route::put('/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');
});
