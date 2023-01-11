<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function deleteprofile($id)
    {
        if(Auth::check()){

            

            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            
        $trashedUser = User::onlyTrashed()->find($id);
        if($trashedUser){
            return response()->json(['error' => 'User already deleted'], 400);
        }
    
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
                'status_code' => 200,
            ], 200);
        
        }  
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }
    }



    public function changepassword(Request $request){
        if(Auth::check()){
            
           $validate = $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required',
            ]);

            

            $user = auth()->user();

            $oldPassword = $request->input('old_password');
            $newPassword = $request->input('new_password');
            $confirmPassword = $request->input('confirm_password');
    

            if (!Hash::check($oldPassword, $user->password)) {
            
                return response()->json([
                    'status' => 'error',
                    'message' => 'Old password is incorrect',
                    'status_code' => 401,
                ], 401);
            }

            if ($newPassword != $confirmPassword) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password and confirm password does not match',
                    'status_code' => 401,
                ], 401);
            }

            $user->password = Hash::make($newPassword);

            $user->save();      
            
            return response()->json([
                'status' => 'success',
                'message' => 'Password changed successfully',
                'status_code' => 200,
            ], 200);
    }
    else{   
        return response()->json([
            'status' => 'error',
            'message' => 'You are not logged in',
            'status_code' => 401,
        ], 401);
    }
}

}