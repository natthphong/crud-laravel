<?php

use App\Http\Controllers\UserTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/", function (Request $request){
    return response()->json(["message"=>"hello world"], 200);
});
Route::post("/", function (Request $request){
    return response()->json(["message"=>"hello world"], 200);
});
Route::post('/register', [UserTestController::class, 'register']);
Route::post('/login', [UserTestController::class, 'login']);
Route::get('/users', [UserTestController::class, 'listUsers']);
