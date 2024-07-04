<?php

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserTestController;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get("/test", function (Request $request){
    return response()->json(["message"=>UserTest::test()], 200);
});
Route::get("/", function (Request $request){
    return response()->json(["message"=>"hello world"], 200);
});
Route::post("/", function (Request $request){
    return response()->json(["message"=>"hello world"], 200);
});
Route::post('/register', [UserTestController::class, 'register']);
Route::post('/login', [UserTestController::class, 'login']);
Route::get('/users', [UserTestController::class, 'listUsers']);

Route::middleware(['tokenAdmin'])->group(function () {
    Route::get('/auth', [UserProfileController::class,"generateOtp"]);
    Route::get('/auth/email', [UserProfileController::class,"sendEmail"]);
});
