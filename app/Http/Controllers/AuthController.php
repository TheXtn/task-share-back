<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8', // Ensure password is provided and has a minimum length
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while registering the user.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                'error' => 'Invalid credentials. Please check your email and password.',
            ], 401);
        }

        try {
            $user = User::where('email', $validatedData['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred during login.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $request->user()->id,
            'username' => 'string|max:255|unique:users,username,' . $request->user()->id,
        ]);

        try {
            $user = $request->user();
            $user->update($validatedData);

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the profile.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
