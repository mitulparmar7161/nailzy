<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CustomerAPI\CustomerController;


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


// Authantication Routes

Route::middleware(['api.log'])->group(function () {
Route::post('registersalon', [AuthController::class, 'registersalon']);
Route::post('registercustomer', [AuthController::class, 'registercustomer']);
Route::post('registeremployee', [AuthController::class, 'registeremployee']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');



 





// Customer Routes


Route::middleware('auth:api')->group( function () {
    Route::get('salondetails', [CustomerController::class, 'salondetails'])->name('salondetails');
    Route::get('salonreviews', [CustomerController::class, 'salonreviews'])->name('salonreviews');
    Route::get('employeereviews', [CustomerController::class, 'employeereviews'])->name('employeereviews');
    Route::get('employeedetails', [CustomerController::class, 'employeedetails'])->name('employeedetails');
    Route::get('services', [CustomerController::class, 'services'])->name('services');
    
});

});



     
