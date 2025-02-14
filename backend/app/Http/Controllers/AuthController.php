<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // Generate the avatar URL
        $profilePic = "https://avatar.iran.liara.run/username?username={$fields['first_name']}+{$fields['last_name']}";

        // Add the avatar URL to the $fields array
        $fields['avatar'] = $profilePic;

        $user = User::create($fields);

        $token = $user->createToken($user->email);

        return response([
            'message' => 'User registered successfully',
            'user' => $user,
            'accessToken' => $token->plainTextToken
        ], 201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'email or password is incorrect'
            ], 422);
        }

        $token = $user->createToken($user->email);

        return response([
            'message' => 'User logged in successfully',
            'user' => $user,
            'accessToken' => $token->plainTextToken
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response([
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $avatar = $user->avatar;

        // Check if the avatar field starts with 'http'
        if (!Str::startsWith($avatar, 'http')) {
            $avatar = url(Storage::url($avatar));
        }

        $user->avatar = $avatar;

        return $user;
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'nullable|max:255',
            'phone_no' => 'nullable|max:255',
            'avatar' => 'nullable|image',
        ]);

        if ($request->hasFile('avatar')) {
            $fields['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($fields);

        return response([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (!Hash::check($fields['current_password'], $user->password)) {
            return response([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($fields['password'])
        ]);

        return response([
            'message' => 'Password updated successfully'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();

        return response([
            'message' => 'User deleted successfully'
        ]);
    }

    // TODO: forgot, reset password
}
