<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\CursoModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CursoModuloController extends Controller
{

    public function index()
    {

        $cursosModulos = CursoModulo::join('cursos','cursos.id','curso_id')
        ->where('cursos.users_id',Auth::id())
        ->all();
        return view('modulos.modulos_home', compact('cursosModulos'));
    }



    public function removerAssociacao(Request $request)
    {


        $ids = $request->ids;


        if (empty($ids)) {
            return redirect()->back()->with('error', 'Nenhum módulo selecionado.');
        }

        $idsArray = explode(',', $ids);


        if (count($idsArray) > 0) {
            foreach ($idsArray as $modulo) {

                $myModulo = CursoModulo::where('id', $modulo)->first();
                CursoModulo::where('id', $modulo)->delete();

                if ($myModulo) {
                    Modulo::where('id', $myModulo->modulo_id)->delete();
                }

            }
        }

        return redirect()->route('modulos')->with('success', 'Módulos excluídos com sucesso!');
    }
}
