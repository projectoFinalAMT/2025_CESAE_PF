<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class moduloController extends Controller
{
    public function index(){
        return view('modulos.modulos_home');
    }
}
