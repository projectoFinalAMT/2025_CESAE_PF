<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunoModuloController extends Controller
{
    public function atualizarMedias(Request $request)
    {


        $data = $request->validate([
            'medias'   => ['required', 'array'],
            'medias.*' => ['numeric'],
        ]);

        $medias = $data['medias'];

        DB::transaction(function () use ($medias) {
            foreach ($medias as $alunoId => $media) {
                DB::table('alunos_modulos')
                    ->where('alunos_id', $alunoId)
                    ->update(['notaAluno' => round((float)$media, 2)]);
            }
        });

        session()->flash('success', 'Médias atualizadas com sucesso.'); // flash para a próxima request
    return response()->json(['ok' => true]);
    }
}
