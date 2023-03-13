<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications;

class ServiceWorkerController extends Controller
{
    public function index(){
        $pushNotifications = new PushNotifications(array(
            "instanceId" => "b057dbbd-15b7-48ba-9ce3-6e9bfa5e3bba",
            "secretKey" => "F7DAF0E519A4351018C5FC82CC55BB4C7C868F521B6495A0CA428F92B46A6280",
        ));
        return view('service-worker');
    }
}
