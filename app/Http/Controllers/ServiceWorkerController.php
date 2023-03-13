<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceWorkerController extends Controller
{
    public function index(){
        return view('service-worker');
    }
}
