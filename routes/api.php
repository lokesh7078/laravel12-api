<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\TestApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// First API Route for testing

Route::get('/test', [TestApiController::class, 'test'])->name(name: 'test-api'); 

Route::apiResource('/students', controller:StudentApiController::class);

Route::post('/register',[AuthController::class,'register'])->name(name:'register');

Route::post('/login',[AuthController::class,'login'])->name('login');

Route::group(['middleware'=> 'auth:sanctum'],function () {
Route::get('/profile',[AuthController::class,'profile'])->name('profile');
 Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//  Route::get('/logout',[AuthController::class,'logout'])->name('logout');

