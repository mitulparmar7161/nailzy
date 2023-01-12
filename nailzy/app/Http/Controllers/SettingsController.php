<?php

namespace App\Http\Controllers;
use App\Models\support;
use App\Models\contact_us;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class SettingsController extends Controller
{


    public function getprofile(){
        if(Auth::check()){
            $user = auth()->user();
            return response()->json([
                'status' => 'success',
                'message' => 'User profile',
                'data' => $user,
                'status_code' => 200
               
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

    public function updateprofile(Request $request){
        if(Auth::check()){
            $user = auth()->user();

            if($user->role == 'customer'){
                $validate = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'mobile' => 'required|unique:users,mobile,'.$user->id,
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
    
                if($validate->fails()){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validation error',
                        'data' => $validate->errors(),
                        'status_code' => 400
                    ], 400);
                }
    
                
                $user->name = request('name');
                $user->email = request('email');
                $user->mobile = request('phone');
                $image_path = $request->file('image')->store('image/customer', 'public');
                $user->image = $image_path;
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'User profile updated successfully',
                    'data' => $user,
                    'status_code' => 200
                   
                ], 200);
            }
            else if($user->role == 'salon'){
                $validate = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'mobile' => 'required|unique:users,mobile,'.$user->id,
                    'address' => 'required',
                    'salon_type' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
    
                if($validate->fails()){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validation error',
                        'data' => $validate->errors(),
                        'status_code' => 400
                    ], 400);
                }
    
                
                $user->name = request('name');
                $user->email = request('email');
                $user->mobile = request('phone');
                $user->address = request('address');
                $user->type = request('salon_type');
                $image_path = $request->file('image')->store('image/salon', 'public');
                $user->image = $image_path;
                $user->save();
            }

        

            return response()->json([
                'status' => 'success',
                'message' => 'User profile updated successfully',
                'data' => $user,
                'status_code' => 200
               
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


public function terms(){

    if(Auth::check()){
        $terms = DB::table('terms')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Terms and conditions',
            'data' => $terms,
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

    
public function faqs(){

    if(Auth::check()){
        $faqs = DB::table('faqs')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'FAQs',
            'data' => $faqs,
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

    public function policies(){

        if(Auth::check()){
            $policies = DB::table('policies')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Policies',
                'data' => $policies,
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



    public function contactus(Request $request){

        if(Auth::check()){

            $validate = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
                'message' => 'required',
            ]);

            $contact = new contact_us;
            $contact->name = request('name');
            $contact->email = request('email');
            $contact->mobile = request('mobile');
            $contact->message = request('message');
            $contact->status = "pending";
            $contact->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
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



    public function support(Request $request){

    if(Auth::check()){
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'message' => 'required',
            'title' => 'required',
        ]);

        $support = new support;
        $support->name = request('name');
        $support->email = request('email');
        $support->mobile = request('mobile');
        $support->message = request('message');
        $support->title = request('title');
        $support->status = "pending";
        $support->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
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