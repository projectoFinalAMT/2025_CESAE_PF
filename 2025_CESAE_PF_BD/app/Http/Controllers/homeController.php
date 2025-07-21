<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
$ola = 'oi mundo';

        return view('home', compact('ola'));
    }
}
