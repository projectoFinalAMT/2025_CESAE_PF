<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class financasController extends Controller
{
     public function index(){
        return view('financas.financas_home');
    }
}
