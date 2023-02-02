<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index(Request $request) {
        $data = $request->validate([
            'email' => 'required|email:dns|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if($user) {
            return Response()->json([
                'messsage' => 'success',
                'notes' => 'silakan login!',
                'data' => [
                    $data,
                ]
            ]);
        }
        
    }
}