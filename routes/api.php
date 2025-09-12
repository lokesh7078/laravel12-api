<?php

use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\TestApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// First API Route for testing

Route::get('/test', [TestApiController::class, 'test'])->name(name: 'test-api'); 

Route::apiResource('/students', controller:StudentApiController::class);