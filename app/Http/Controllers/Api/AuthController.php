<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function authenticate(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = [
            'username' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->remember_token)) {
            $request->session()->regenerate();
            $auth_user = Auth::user();
            $token = $request->user()->createToken($auth_user->name);

            return response()->json([
                'status' => true,
                'message' => 'Authenticated.',
                'data' => [
                    "auth_token" => $token->plainTextToken,
                    "auth_user" => $auth_user,
                    "auth_check" => Auth::check()
                ]
            ]);

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Authenticated.',
            //     'data' => [
            //         "auth_token" => $token->plainTextToken,
            //         "auth_user" => $auth_user
            //     ]
            // ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthenticated.',
            'data' => null
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
