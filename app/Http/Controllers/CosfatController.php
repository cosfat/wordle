<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CosfatController extends Controller
{
    public function index(){

        $users = User::orderBy('id', 'desc')->get();

        return view('cosfat', compact('users'));
    }
}
