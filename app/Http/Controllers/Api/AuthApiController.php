<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        return response()->json([
            'message' => 'Login berhasil 🚀'
        ]);
    }

    public function register(Request $request)
    {
        return response()->json([
            'message' => 'Register berhasil ✨'
        ]);
    }

    public function logout()
    {
        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function me()
    {
        return response()->json([
            'user' => 'User data'
        ]);
    }
    
}