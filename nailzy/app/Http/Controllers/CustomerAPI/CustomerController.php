<?php

namespace App\Http\Controllers\CustomerAPI;

use services;
use Carbon\Carbon;
use App\Models\User;
use App\Models\booking;
use App\Models\service;
use App\Models\favorite;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Models\booked_service;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use App\Models\salon_review;
use App\Models\employee_review;

class CustomerController extends Controller
{
    

    public function filters(Request $request){


        if(Auth::check()){

            $requests = $request->all();
            $salon_type = $requests['salon_type'];
            $service_price = $requests['service_price'];
            $lat = $requests['latitude'];
            $long = $requests['longitude'];
            $range = $requests['range'];   
  

            $salons = DB::table('users')
            ->select('*', DB::raw("(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($long)) + sin(radians($lat)) * sin(radians(latitude)))) AS distance"))
            ->having('distance', '<=', $range)
            ->orderBy('distance')
            ->get();
                    
            return $salons;

        }   
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }
    }



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



    public function bookingslot(Request $request){

        
        if(Auth::check()){


           $request = $request->all(); 

          $service_id = $request['service_id'];  

          foreach($service_id as $service){

            $service_time = DB::table('services')
                            ->where('services.id', $service)
                            ->get('approx_time');

             foreach($service_time as $time) {
                
                    $total_time[] = $time->approx_time;
             }     

          }

          $date = $request['date'];
             
          $day = Carbon::parse($date)->format('l');

          $avail_time = DB::table('availabilities')
                           ->where('availabilities.salon_id', $request['salon_id'])
                            ->where('availabilities.day', $day)
                            ->select('availabilities.start_time','availabilities.end_time')
                            ->get();



          $total_time = collect($total_time)->sum();    

          $timeSlots = [];
          
            foreach($avail_time as $time){
                    
                    $start = $time->start_time;
                    $end = $time->end_time;
    
                    $start = Carbon::parse($start);
                    $end = Carbon::parse($end);
    
                    $diffInMinutes = $start->diffInMinutes($end);
    
                    $numSlots = $diffInMinutes / $total_time;
                
                    if($numSlots > 0) {

                        if($numSlots < 24) {
                            $numSlots = floor($numSlots);
                        }
                        else {
                            $numSlots = 1;
                        }

    
                        for ($i = 0; $i < $numSlots; $i++) {
    
                            $timeSlots[] = ['start' => $start->format('H:i'),
                                            'end' => $start->addMinutes($total_time)->format('H:i')];
    
                        }
                        
                    }      
            }
            return response()->json([   
                'status' => 'success',
                'data' => $timeSlots,
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



    public function confirmbooking(Request $request){


        if(Auth::check()){

            $request = $request->all();
            
            $validator = Validator::make($request,[
                'salon_id' => 'required',   
                'booking_date' => 'required',
                'timeslot_start' => 'required',
                'timeslot_end' => 'required',
                'billing_cost' => 'required',
                'booking_status' => 'required',
                'booking_remark' => 'required',   
                'service_id' => 'required',
            ]); 

            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                    'status_code' => 400,
                ], 400);  
            }

            $request['customer_id'] = Auth::user()->id;
            $booking = booking::create($request);

            $booking_id = $booking->id;


            // return $booking_id;

            $service_id = $request['service_id'];

            foreach($service_id as $service){

                $booking_service = new booked_service;
                $booking_service->booking_id = $booking_id;
                $booking_service->service_id = $service;
                $offer_price = DB::table('services')
                                ->where('services.id', $service)
                                ->select('offer_price')
                                ->get();
                $booking_service->price = $offer_price[0]->offer_price;
                $booking_service->save();
            }

            return response()->json([   
                'status' => 'success',
                'data' => $booking,
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






    public function customerhistory(Request $request){


        
        if(Auth::check()){


            $request = $request->all();

           

            $customer_id = auth()->user()->id;


            $bookings = DB::table('bookings')
                        ->where('customer_id',$customer_id)
                        ->where('booking_status',$request['booking_status'])
                        ->join('users', 'users.id', '=', 'bookings.salon_id')
                        ->select('bookings.*', 'users.name as salon_name','users.image as salon_image','users.address as salon_address')
                        ->get();
                       

            return $bookings;



        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }

    }


    public function customerhistorydetails(Request $request){

        if(Auth::check()){


            $request = $request->all();


            $booking_id = $request['booking_id'];
            
            $booking_details = DB::table('bookings')
                        ->where('bookings.id',$booking_id)
                        ->join('users', 'users.id', '=', 'bookings.salon_id')
                        ->select('bookings.salon_id as salon_id','bookings.employee_id as employee_id','bookings.booking_date as booking_date','timeslot_start','timeslot_end','users.name as salon_name','users.image as salon_image','users.address as salon_address','users.mobile as salon_mobile','users.email as salon_email')
                        ->get();
                       
                foreach($booking_details as $booking){

                    $reviews = DB::table('salon_reviews')
                    ->where('salon_reviews.salon_id', $booking->salon_id)
                    ->get(); 
        
                    $booking->total_reviews_salon = $reviews->count();
                   
                    $averageRating_salon = DB::table('salon_reviews')
                    ->where('salon_id', $booking->salon_id)
                    ->get('salon_rating');
        
                     $booking->average_salon_rating = round($averageRating_salon->avg('salon_rating'), 1);

                    if($booking->employee_id != null){

                        
                $employeereviews = DB::table('users')
                ->where('users.id', $booking->employee_id)
                ->select('users.id','users.name','users.image','users.service as employee_service')
                ->get();


                
                
    
            foreach($employeereviews as $employeereview){

            $reviews_emp = DB::table('employee_reviews')
            ->where('employee_reviews.employee_id', $employeereview->id)
            ->get(); 

            $employeereview->numberofereviews = $reviews_emp->count();
           
            $averageRating = DB::table('employee_reviews')
            ->where('employee_id', $employeereview->id)
            ->get('employee_rating');

             $employeereview->averagerating = round($averageRating->avg('employee_rating'), 1);
     
                }   
                $booking->employee = $employeereviews;

                    }
                    else{
                        $booking->employee = "Employee is not assigned yet";
                    }
                }

                         return $booking_details;



        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in',
                'status_code' => 401,
            ], 401);
        }

    }




    public function addreviews(Request $request){

            if(Auth::check()){
                

                $request = $request->all();


                $validator = Validator::make($request, [
                    'salon_id' => 'required',
                    'salon_rating' => 'required',
                    'salon_comment' => 'required',
                    'employee_id' => 'required',
                    'employee_rating' => 'required',
                    'employee_comment' => 'required',
                ]);
                

                if($validator->fails()){
                    return response()->json([
                        'status' => 'error',
                        'message' => $validator->errors(),
                        'status_code' => 400,
                    ], 400);  
                }
                
                $request['customer_id'] = Auth::user()->id; 

                $salon_review = salon_review::create($request);

                $employee_review = employee_review::create($request);
                
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        $salon_review,
                        $employee_review
                    ],
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