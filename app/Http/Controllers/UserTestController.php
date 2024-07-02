<?php

namespace App\Http\Controllers;

use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
class UserTestController extends Controller
{
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
            $user = UserTest::query()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'age' => $request->age,
            ]);
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
            $user = UserTest::query()->where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return response()->json($user, 200);
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
        $users = UserTest::all();
        return response()->json(["users"=>$users], 200);
    }
}
