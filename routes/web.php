<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('employee')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Employee/Index');
    })->name('employee.list');

    Route::get('/create', function () {
        return Inertia::render('Employee/Form', [
            'status' => 'create',
        ]);
    })->name('employee.create');

    Route::get('/edit/{id}', function (int $id) {
        return Inertia::render('Employee/Form', [
            'status' => 'edit',
            'employeeID' => $id
        ]);
    })->name('employee.edit');
})->middleware(['auth', 'verified']);


// login and authentication
Route::middleware('guest')
    ->group(function () {
        Route::get('/', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    });

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'destroy'])
        ->name('logout');
});
