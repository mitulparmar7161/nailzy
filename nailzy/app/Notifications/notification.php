<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmNotification;

class AccountApproved extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'title' => 'Your account has been approved!',
                'body' => 'You can now log in to the app.',
            ])
            ->setNotification(FcmNotification::create()->setTitle('Account Approved'));
    }
}                                           
