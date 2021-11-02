<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\TokenNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\Cast\String_;

class NotificationController extends Controller
{
    public function createNotification(Request $request)
    {
        $token = TokenNotifications::where('token_notifications.customer_id' , $request->input('customer_id'))->get("token_notifications.token");
        echo $token[0]->token;
        $notification  = new Notification();
        $notification->customer_id = $request->input('customer_id');
        $notification->token = $token[0]->token;
        $notification->title = $request->input('title');
        $notification->body = $request->input('body');
        $notification->save();
        $SERVER_API_KEY = 'AAAAm-3C6Bk:APA91bE5engx0oUQguIp0io9B32W5LBhAE-AiWUoPT6voLbmXSA7NgYx-8-qUXO_sFx-n5SUX6iX4gQYNu252rwk7IKWG3edM0NHNClQnBsIl9QRdUfj_SBjDD3oT-QRbJXrCzPF7A5V';

        $data = [
            "registration_ids" => array($notification->token),
            "notification" => [
                "title" => $notification->title,
                "body" => $notification->body,
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }
    public function displayAllNotifications()
    {
        return Notification::all();
    }
}
