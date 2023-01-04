<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    

    public function home(Request $request)
    {

        if (Auth::check()) {
        
        $requests = $request->all();
        $search = $requests['search'];
        $salon_type = $requests['salon_type'];

        $data = User::where('name', 'LIKE', "%{$search}%")
            ->where('salon_type', $salon_type)
            ->get();


        return response()->json([   
            'status' => 'success',
            'data' => $data,
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