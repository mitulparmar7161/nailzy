<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function registercustomer(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|number|max:10|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
    }

    $request['password'] = bcrypt($request->password);
    $user = User::create($request->toArray());

    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
    $response = ['token' => $token];

    return response($response, 200);
}
}
