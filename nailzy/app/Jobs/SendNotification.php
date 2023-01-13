<?php

namespace App\Jobs;

use App\Http\Controllers\FCM;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $title;
    public $message;
    public $deviceToken;
    public $payload;
    public $type;
    public $notificationstatus;
    public function __construct($title,$message,$deviceToken,$type,$payload,$notificationstatus)
    {
        $this->title = $title;
        $this->message = $message;
        $this->deviceToken = $deviceToken;
        $this->type = $type;
        $this->payload = $payload;
    }

    public function handle()
    {   

        $fcm = new FCM;
        $fcm->sendFCM($this->title,$this->message,$this->deviceToken, $this->type,$this->payload,$this->notificationstatus);
    }
}
