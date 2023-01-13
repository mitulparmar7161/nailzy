<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCM extends Controller
{

    function sendFCM($title, $message,$deviceIdsonly, $deviceType, $notification_payload,$notificationstatus)

{

  try {

      $url = "https://fcm.googleapis.com/fcm/send";
      $server_key = "AAAAXND17_g:APA91bHd3habpsYEhK2F6EMjgMNEqJYTZDkKmzFnAVk_U4E3ZRkhUeIuetc8Ji1FezkZwQs8lgmrIPtPSNoY-1DWT3MHYqrgM-UDuh_HtrSimLiGzknuUFknM833RYbPctCmTaN4oYkA";
      $fields = array();
      $fields['content_available'] = false;
      $fields['silent']= true;
     
      if ($deviceType == "android") {
          $fields['data'] = array();
          $fields['data']['title'] = $title;
          $fields['data']['body'] = $message;
          $fields['data']['notification_data'] = $notification_payload;
          $fields['data']['notificationstatus'] = $notificationstatus;
          $fields['data']['click_action'] = '.MainActivity';
          $fields['data']['sound'] = 'default';

      } else if ($deviceType == "iOS") {
          //Meaning iOS
          $fields['notification'] = array();
          $fields['notification']['title'] = $message;
          $fields['notification']['body'] = $title;
          $fields['notification']['extra_support_message'] = $notification_payload;
          $fields['notification']['click_action'] = '.MainActivity';
          $fields['notification']['sound'] = 'default';
      }
      $fields['to'] = $deviceIdsonly;
      $fields['priority'] = "high";
      $headers = array(
          'Content-Type:application/json',
          'Authorization:key=' . $server_key,
      );
      $fields = json_encode($fields);
      //print_r($fields);die;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      $result = curl_exec($ch);
      if ($result === false) {
        die('FCM Send Error: ' . curl_error($ch));
    }
      curl_close($ch);
      echo $fields;
      return $result;
      }catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went to wrong.');
      }
  }


}
