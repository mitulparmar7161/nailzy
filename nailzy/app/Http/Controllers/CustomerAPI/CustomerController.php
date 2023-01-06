<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Models\User;
use App\Models\favorite;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    

    public function salondetails(Request $request)
    {

        if (Auth::check()) {
        
        $requests = $request->all();
        $search = $requests['search'];
        $salon_type = $requests['salon_type'];
        
        $user_id = Auth::user()->id;
      
            
  
        $salons = DB::table('users')
        ->where('users.salon_type', $salon_type)
        ->where('users.name', 'like', '%' . $search . '%')
        ->get();

        
        $favorites = favorite::where('customer_id',$user_id)->where('status',1)->get();


        foreach($salons as $salon){

            $reviews = DB::table('salon_reviews')
            ->where('salon_reviews.salon_id', $salon->id)
            ->get(); 

            $salon->numberofereviews = $reviews->count();
           
            $averageRating = DB::table('salon_reviews')
            ->where('salon_id', $salon->id)
            ->get('salon_rating');

             $salon->averagerating = round($averageRating->avg('salon_rating'), 1);
             
        foreach($favorites as $favorite){
            
                if($salon->id == $favorite->salon_id){
                    $salon->favorite = 1;
                }
                else{
                    $salon->favorite = 0;
                }
        }            
        }
        
        



        return response()->json([   
            'status' => 'success',
            'data' => $salons,
            'status_code' => 200,
        ], 200);
            
    }
    else {
        return response()->json([
            'status' => 'error',
            'message' => 'You are not logged in',
            'status_code' => 401,
        ], 401);
    }

}




        public function salonreviews(Request $request){


            if (Auth::check()) {

                $request = $request->all();
                $salon_id = $request['salon_id'];

                $reviews = DB::table('salon_reviews')
                ->where('salon_reviews.salon_id', $salon_id)
                ->join('users', 'users.id', '=', 'salon_reviews.customer_id')
                ->select('salon_reviews.salon_comment','salon_reviews.salon_rating','users.id','users.name')
                ->get();

                return response()->json([   
                    'status' => 'success',
                    'data' => $reviews,
                    'status_code' => 200,
                ], 200);






            }
            else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not logged in',
                    'status_code' => 401,
                ], 401);
            }
        }





        public function employeereviews(Request $request){


            if(Auth::check()){

                $request = $request->all();
                $salon_id = $request['salon_id'];


                $employeereviews = DB::table('users')
                ->where('users.salon_id', $salon_id)
                ->select('users.id','users.name','users.image')
                ->get();


                
                
                
        foreach($employeereviews as $employeereview){

            $reviews = DB::table('employee_reviews')
            ->where('employee_reviews.employee_id', $employeereview->id)
            ->get(); 

            $employeereview->numberofereviews = $reviews->count();
           
            $averageRating = DB::table('employee_reviews')
            ->where('employee_id', $employeereview->id)
            ->get('employee_rating');

             $employeereview->averagerating = round($averageRating->avg('employee_rating'), 1);
     
        }

        return response()->json([   
            'status' => 'success',
            'data' => $employeereviews,
            'status_code' => 200,
        ], 200);



        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }
    }



    public function employeedetails(Request $request){


        if(Auth::check()){

            $request = $request->all();
            $employee_id = $request['employee_id'];

            $employeedetails = DB::table('users')
            ->where('users.id', $employee_id)
            ->select('users.id','users.name','users.image')
            ->get();


            foreach($employeedetails as $employeedetail){

                $reviews = DB::table('employee_reviews')
                ->where('employee_reviews.employee_id', $employeedetail->id)
                ->get(); 
    
                $employeedetail->numberofereviews = $reviews->count();
               
                $averageRating = DB::table('employee_reviews')
                ->where('employee_id', $employeedetail->id)
                ->get('employee_rating');
    
                 $employeedetail->averagerating = round($averageRating->avg('employee_rating'), 1);
    
                 $review = DB::table('employee_reviews')
                 ->where('employee_reviews.employee_id', $employeedetail->id)
                 ->join('users', 'users.id', '=', 'employee_reviews.customer_id')
                 ->select('employee_reviews.employee_comment','employee_reviews.employee_rating','users.id','users.name')
                 ->get();
                 
                  $employeedetail->customerreviews = $review;        
            }
    
            return response()->json([   
                'status' => 'success',
                'data' => $employeedetails,
                'status_code' => 200,
            ], 200);
    
    
    
            }


        else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }

    }



    public function services(Request $request){

        if(Auth::check()){

            $request = $request->all();
            $salon_id = $request['salon_id'];

            $services = DB::table('services')
            ->where('services.salon_id', $salon_id)
            ->get();

            foreach($services as $service){


                $minutes = $service->approx_time;
                $hours = CarbonInterval::seconds($minutes * 60)->cascade()->forHumans();
                $service->approx_time_in_hours = $hours;  

                $images = DB::table('service_images')
                ->where('service_images.service_id', $service->id)
                ->select('service_images.image')
                ->get();
                $service->service_images = $images;
            }


            return response()->json([   
                'status' => 'success',
                'data' => $services,
                'status_code' => 200,
            ], 200);
    

        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }



    }

}