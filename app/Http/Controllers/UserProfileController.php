<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileController extends Controller
{
    //

    public function generateOtp():JsonResource
    {
        $ref  =uuid_generate_sha1();
        return response()->json(["status"=>200,"token"=>$ref],200);
    }

}
