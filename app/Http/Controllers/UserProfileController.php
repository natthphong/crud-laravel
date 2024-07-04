<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    //

    public function generateOtp(): JsonResponse
    {
        $ref = Str::uuid();

        return response()->json(["status" => 200, "ref" => $ref], 200);
    }

}
