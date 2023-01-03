<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\auth\BaseController;


class AuthController extends BaseController
{
    public function registercustomer(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|integer|max:10|unique:users',
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

    public function registersalon(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|integer|unique:users',
        'password' => 'required|string|min:8',
        'image' => 'mimes:jpeg,jpg',
        'address' => 'required|string',
        'salon_type' =>'required|string',
        'role' => 'required|string',
        
    ]);

    if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors()); 
    }

        $input = $request->all();
        $image_path = $request->file('image')->store('image', 'public');
        $input['image']       = $image_path;
        $input['password']    = bcrypt($input['password']);
        $user                 = User::create($input);
        $success['token']     =  $user->createToken('MyApp')->accessToken;
        $success['name']      =  $user->name;
        $success['email']     =  $user->email;
        $success['mobile']    =  $user->mobile;
        $success['address']   =  $user->address;
        $success['salon_type']=  $user->salon_type;
        $success['image']     =  $image_path;
        $success['role']      =  $user->role;

        return $this->sendResponse($success, 'User register successfully.');
    
}
}
