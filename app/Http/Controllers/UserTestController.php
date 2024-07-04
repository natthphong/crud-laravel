<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Parser\Parser;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\Manager;

class UserTestController extends Controller
{

    protected $jwt;

    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }
    public function register(Request $request): JsonResponse
    {
        Log::debug("Start registration");

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:user_tests',
                'password' => 'required|string|min:8',
                'age' => 'required|integer',
            ]);
            Log::debug("Validation successful. Name: " . $request->email);
//            $user = User::query()->create([
//                'name' => $request->name,
//                'email' => $request->email,
//                'password' => Hash::make($request->password),
////                'age' => $request->age,
//            ]);
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
//                'age' => $request->age,
            ]);
            $user->save();

//            $user = UserTest::create([
//                 'name' => $request->name,
//                 'email' => $request->email,
//                 'password' => Hash::make($request->password),
//                 'age' => $request->age,
//             ]);


            return response()->json(["users" => $user], 201);

        } catch (ValidationException $e) {
            Log::error("Validation failed: " . $e->getMessage());
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }catch (\Exception $e) {
            Log::error("Failed to register user: " . $e->getMessage());
            return response()->json([
                'message' => 'Failed to register user',
            ], 500);
        }

    }


    public function login(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            $user = User::query()->where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $credentials = request(['email', 'password']);
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }


//            $token = $this->jwt->fromSubject($userJwt);
//            $token = $jwt->fromSubject($userJwt);


            Log::info("LOGIN SUCCESS");

            return response()->json([
                'user' => $user,
                    'token' => $token,
            ], 200);
        }catch (ValidationException $e) {
            Log::error("Validation failed: " . $e->getMessage());
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }catch (\Exception $e) {
            Log::error("Failed to register user: " . $e->getMessage());
            return response()->json([
                'message' => 'Failed to register user',
            ], 500);
        }

    }
    public function listUsers()
    {
        $users = User::all();
        return response()->json(["users"=>$users], 200);
    }
}
