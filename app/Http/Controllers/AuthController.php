<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="User registration.",
     *     description="Creates a new user registration.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Muzaffer DOGAN"),
     *             @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(response=201, description="Registration successful."),
     *     @OA\Response(response=422, description="Invalid login.")
     * )
     */

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token' => $token,
            'token_type' => 'Bearer',
        ],201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login.",
     *     description="Logs in for the existing user.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Login successful."),
     *     @OA\Response(response=401, description="Unauthorized.")
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid login information'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="User logout.",
     *     description="Logs out the currently logged-in user from the system.",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Logout successful."),
     *     security={{"sanctum": {}}}
     * )
     */
    public function logout(): JsonResponse
    {
        if (auth()->user()){
            auth()->user()->tokens()->delete();
            return response()->json(['message' => 'Logout successful']);
        }else{
            return response()->json(['message' => 'Already logged out']);
        }

    }
}
