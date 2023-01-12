<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CustomerAPI\CustomerController;
use App\Http\Controllers\SettingsController;

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
    Route::post('bookingslot', [CustomerController::class, 'bookingslot'])->name('bookingslot');
    Route::post('confirmbooking', [CustomerController::class, 'confirmbooking'])->name('confirmbooking');
    Route::get('filters',[CustomerController::class, 'filters'])->name('filters');
    Route::get('customerhistory',[CustomerController::class, 'customerhistory'])->name('customerhistory');
    Route::get('customerhistorydetails',[CustomerController::class, 'customerhistorydetails'])->name('customerhistorydetails');
    Route::post('addreviews',[CustomerController::class, 'addreviews'])->name('addreviews');




    Route::delete('deleteprofile/{id}', [SettingsController ::class, 'deleteprofile'])->name('deleteprofile');

    Route::post('changepassword', [SettingsController ::class, 'changepassword'])->name('changepassword');

    Route::get('terms', [SettingsController ::class, 'terms'])->name('terms');

    Route::get('faqs', [SettingsController ::class, 'faqs'])->name('faqs');

    Route::get('policies', [SettingsController ::class, 'policies'])->name('policies');

    Route::get('getprofile', [SettingsController ::class, 'getprofile'])->name('getprofile');

    Route::post('updateprofile', [SettingsController ::class, 'updateprofile'])->name('updateprofile');

    Route::post('contactus', [SettingsController ::class, 'contactus'])->name('contactus');

    Route::post('support', [SettingsController ::class, 'support'])->name('support');

});

}); 



     
