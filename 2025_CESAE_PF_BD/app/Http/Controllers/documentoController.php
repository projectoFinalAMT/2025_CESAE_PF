<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class documentoController extends Controller
{
    public function index(){
        return view('documentos.documentos_home');
    }
}
