<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Success',
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken
            ]);
        }

        return response()->json(['message' => 'Username or password incorrect'], 401);
    }

    public function password(Request $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return true;
    }
}
