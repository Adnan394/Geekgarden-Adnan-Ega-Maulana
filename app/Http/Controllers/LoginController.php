<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function index(Request $request) {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || ! Hash::check($request->password, $user->password)) {
            return Response()->json([
                'message' => 'login invalid!',
            ]);
        }

        $token = $user->createToken('login')->plainTextToken;

        return Response()->json([
            'message' => 'login success!',
            'data' => $user,
            'meta' => [
                'token' => $token,
            ]
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return Response()->json([
            'message' => 'Logout Success!'
        ]);
    }
}