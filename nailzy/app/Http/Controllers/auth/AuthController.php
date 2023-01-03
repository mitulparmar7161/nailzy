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
        'role' => 'required|string',
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|number|max:10|unique:users',
        'password' => 'required|string|min:8',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response('Validation Error.', $validator->errors());
    }

    $input = $request->all();   
    $image_path = $request->file('image')->store('image/user', 'public');
    $input['image'] = $image_path;
    $input['password'] = bcrypt($input['password']);



    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->accessToken;
    $success['name'] =  $user->name;
    $success['email'] =  $user->email;
    $success['mobile'] =  $user->mobile;
    $success['image'] = $image_path;
    $success['role'] = $user->role;

    return $this->sendResponse($success, 'User register successfully.');
    
}
}
