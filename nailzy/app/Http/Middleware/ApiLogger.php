<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


   

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if (config('app.log') == 1) {
                   // Log::info('API Request', [
        //     'method' => $request->method(),
        //     'url' => $request->fullUrl(),
        //     'body' => $request->all(),
        // ]);

   

        // Log the request and response
        $log =  [
          [
            'date_time' =>  Carbon::now()->toDateTimeString(), 

            'request' => [

                'method' =>  $request->method(),
                'url' => $request->fullUrl(),
                'body' => json_encode( $request->all())
            
            ],

            'response' => [
                'status' =>  $response->status(),
                'body' =>  $response->content()
            ],

            ],
        ];

        $logFile = storage_path('logs/logs.txt');
        
        $json = File::get($logFile);
    
        if (empty($json)) {
            
            $log = json_encode($log, JSON_PRETTY_PRINT);
    
            file_put_contents($logFile, $log , FILE_APPEND);

        }
        else{
            $data = json_decode($json, true);

            File::put($logFile, '');
    
            $newdata = array_merge($data, $log);
            
            $newdata = json_encode($newdata, JSON_PRETTY_PRINT);
    
            file_put_contents($logFile, $newdata , FILE_APPEND);
        }


            
        }
 
      
        return $response;
    }
}
