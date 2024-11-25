<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    public function registerUser(Request $request)
    {
        $dataUser = new User();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Porcess Validation Fail',
                'data' => $validator->errors()
            ],401);
        }


        $dataUser->name = $request->name;
        $dataUser->email = $request->email;
        $dataUser->password = Hash::make($request->password);
        $dataUser->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfulyy added New data'
        ],200);
    }

    public function login(Request $request)
    {
        $dataUser = new User();
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Porcess Login Fail',
                'data' => $validator->errors()
            ],401);
        }

        if (!Auth::attempt($request->only(['email','password']))) {
            return response()->json([
                'status' => false,
                'message' => "Email Or Password Do Not Match",
            ],401);
        }

        $dataUser = User::where('email',$request->email)->first();
        return response()->json(
            [
                'status'=> true,
                'message' => 'Successfully Process Login',
                'token' => $dataUser->createToken('api-product')->plainTextToken
            ]
        );

    }

}
