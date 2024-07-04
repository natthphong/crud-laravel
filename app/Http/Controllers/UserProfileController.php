<?php

namespace App\Http\Controllers;

use App\Mail\SendReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    //

    public function generateOtp(Request $request): JsonResponse
    {
        $ref = Str::uuid();

        return response()->json(["status" => 200, "ref" => $ref , "email"=>$request->auth_user->email], 200);
    }

    public function sendEmail(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255'
            ]);
            $mailData = [
                'title' => 'This is Test Mail'
            ];
            $ref = Str::uuid();
            $email = $request->email;
            $sendRe = new SendReport($mailData);
            Mail::to($email)->send($sendRe);
            return response()->json(["status" => 200, "ref" => $ref, "email" => $request->auth_user->email], 200);
        } catch (\Exception $e) {
            print_r("error" ,$e->getMessage() );
            return response()->json(['error' => 'Failed to send email', 'message' => $e->getMessage()], 500);
        }
    }
}
