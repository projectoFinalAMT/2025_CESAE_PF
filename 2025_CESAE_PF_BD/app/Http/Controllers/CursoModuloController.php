<?php

namespace App\Http\Controllers;

use App\Models\CursoModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoModuloController extends Controller
{

    public function index(){

        $cursosModulos = CursoModulo::all();
        return view('modulos.modulos_home', compact('cursosModulos'));
    }



public function removerAssociacao(Request $request)
{
    $ids = $request->ids;


    if(empty($ids)) {
        return redirect()->back()->with('error', 'Nenhum módulo selecionado.');
    }

    $idsArray = explode(',', $ids);

    if(count($idsArray) > 0) {
        CursoModulo::whereIn('id', $idsArray)->delete();
    }

    return redirect()->route('modulos')->with('success', 'Módulos excluídos com sucesso!');
}
}
