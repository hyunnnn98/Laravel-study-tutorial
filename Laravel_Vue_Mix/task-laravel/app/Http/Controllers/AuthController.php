<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        // $validated = $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string'
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required:string',
        ]);

        // Validator 오류
        if ($validator->fails()) {
            return \response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        // 로그인 정보가 틀린 경우
        if (!\Auth::attempt($validator)) {
            return response()->json([
                'message' => 'Incorrect Email or Password'
            ], 401);
        }

        // if (!\Auth::attempt($validator)) {
        //     return response()->json([
        //         'message' => 'Incorrect Email or Password'
        //     ], 422);
        // }

        $user = $request->user();

        return response()->json([
            'token' => $user->createToken('Personal Access Token')->accessToken,
            'user' => $user,
        ], 200);
    }

    public function logout()
    {
        // 리퀘스트에 담긴 토큰 정보를 확인 후 => 해당 사용자 User 정보 확인 가능!
        $user = request()->user();
        $user->token()->revoke();

        return response()->json([
            'message' => 'The user has benn successfuly logged out',
            'user' => $user
        ], 200);
    }
}
