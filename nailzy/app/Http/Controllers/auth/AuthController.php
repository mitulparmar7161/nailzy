<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Auth\BaseController;

class AuthController extends BaseController
{
    public function registercustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|integer|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $input = $request->all();   
        $image_path = $request->file('image')->store('image/customer', 'public');
        $input['image'] = $image_path;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['id'] =  $user->id;
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['role'] =  $user->role;
        $success['email'] =  $user->email;
        $success['mobile'] =  $user->mobile;
        $success['image'] = $image_path;
        $success['status']    =  $user->status;
        $success['device_token'] =  $user->device_token;
        $success['device_type'] =  $user->device_type;
        $success['notification'] =  $user->notification;
        

        return $this->sendResponse($success, 'User register successfully.');


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
        $image_path = $request->file('image')->store('image/salon', 'public');
        $input['image']       = $image_path;
        $input['password']    = bcrypt($input['password']);



        $user                 = User::create($input);
        $success['id'] =  $user->id;
        $success['token']     =  $user->createToken('MyApp')->accessToken;
        $success['name']      =  $user->name;
        $success['email']     =  $user->email;
        $success['mobile']    =  $user->mobile;
        $success['address']   =  $user->address;
        $success['salon_type']=  $user->salon_type; 
        $success['image']     =  $image_path;
        $success['role']      =  $user->role;
        $success['status']    =  $user->status;
        $success['device_token'] =  $user->device_token;
        $success['device_type'] =  $user->device_type;
        $success['notification'] =  $user->notification;


        return $this->sendResponse($success, 'User register successfully.');
    
}   


public function registeremployee(Request $request)
{
    $validator = Validator::make($request->all(), [
        'role' => 'required|string',
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|integer|unique:users',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'service' => 'required|string',
        'salon_id' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
    }
    $input = $request->all();   
    $image_path = $request->file('image')->store('image/employee', 'public');
    $input['image'] = $image_path;
    $user = User::create($input);
    $success['id'] =  $user->id;
    $success['token'] =  $user->createToken('MyApp')->accessToken;
    $success['name'] =  $user->name;
    $success['role'] =  $user->role;
    $success['email'] =  $user->email;
    $success['mobile'] =  $user->mobile;
    $success['image'] = $image_path;
    $success['status']    =  $user->status;
    $success['service'] =  $user->service;
    $success['salon_id'] =  $user->salon_id;    

    

    return $this->sendResponse($success, 'User register successfully.');


}



}
