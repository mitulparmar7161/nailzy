<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('registersalon', [AuthController::class, 'registersalon']);
Route::post('registercustomer', [AuthController::class, 'registercustomer']);
// Route::post('login', [RegisterController::class, 'login'])->name('login');
// Route::post('search', [RegisterController::class, 'search']);
     
Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class);
});
