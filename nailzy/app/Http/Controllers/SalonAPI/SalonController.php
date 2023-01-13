<?php

namespace App\Http\Controllers\SalonAPI;

use App\Models\service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalonController extends Controller
{
    public function addservice(Request $request){

    if(Auth::check()){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'offer_price' => 'required|numeric',
            'approx_time' => 'required|numeric',   
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }


       
        $service = new Service;
        $service->title = $request->input('title');
        $service->description = $request->input('description');
        $service->price = $request->input('price');
        $service->offer_price = $request->input('offer_price');
        $service->approx_time = $request->input('approx_time');
        $service->salon_id = Auth::user()->id;
        $service->save();



        $data = $request->file('image');


        foreach ($data as $image) {
            $path = $image->store('image/services/'.$service->id.'/', 'public');
            $serviceImage = new ServiceImage;
            $serviceImage->service_id = $service->id;
            $serviceImage->image = $path;
            $serviceImage->save();     
            $allimages[]= $serviceImage->image;
            $service->images = $allimages;
        }
    
    return response()->json([
        'status' => 'success',
        'message' => 'Service added successfully',
        'data' => $service,
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


        public function getservices(Request $request){
            if(Auth::check()){
                $services = Service::where('salon_id', Auth::user()->id)->get();
                foreach ($services as $service) {
                    $service->images = ServiceImage::where('service_id', $service->id)->get('image');
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Services fetched successfully',
                    'data' => $services,
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
}
