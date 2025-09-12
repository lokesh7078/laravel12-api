<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestApiController extends Controller
{
 
public function test(): JsonResponse {
    return response()->json([
        "status" => "success",
        "message" => "API Works"
    ]);
}

   
}
