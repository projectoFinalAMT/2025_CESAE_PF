<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class moduloController extends Controller
{
    /**
     * Exibe a lista de módulos com cursos associados.
     */
    public function index()
    {
        // Carrega todos os cursos com a instituição
        $cursos = Curso::where('cursos.users_id',Auth::id())->with('instituicao')->get();

        // Carrega todos os módulos com os cursos e a instituição de cada curso
        $modulos = Modulo::with([
            'cursos.instituicao',
            'cursoModulos',
            'documentos'
        ])
        ->join('curso_modulo','modulos.id','modulo_id')->join('cursos','cursos.id','curso_id')
            ->where('cursos.users_id',Auth::id())->withCount('documentos')
            ->get();



        // Cria um array de IDs de curso_modulo por módulo e curso
        $cursoModuloIds = [];
        foreach ($modulos as $modulo) {
            foreach ($modulo->cursos as $curso) {
                $cursoModulo = $modulo->cursoModulos->where('curso_id', $curso->id)->first();
                $cursoModuloIds[$modulo->id][$curso->id] = $cursoModulo ? $cursoModulo->id : null;
            }
        }

        // Adiciona propriedades personalizadas se necessário
        foreach ($modulos as $modulo) {
            if (method_exists($modulo, 'todosCursosComAssociacao')) {
                $modulo->todosCursos = $modulo->todosCursosComAssociacao(Auth::id());
            }
            if (method_exists($modulo, 'todosCursosPorInstituicao')) {
                $modulo->todosCursosPorInstituicao = $modulo->todosCursosPorInstituicao();
            }
        }

        $categoriaIdApoio = DB::table('categoria_documentos')
            ->where('categoria', 'apoio')
            ->value('id');

        $documentos = Documento::where('users_id', Auth::id())
        ->with('modulos')
            ->where('categoria_documento_id', $categoriaIdApoio)
            ->get();



        return view('modulos.modulos_home', compact('cursos', 'modulos', 'cursoModuloIds', 'documentos'));
    }


    /**
     * Armazena um novo módulo e associa aos cursos e documentos selecionados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'duracao_horas' => 'required|numeric|min:0',
            'cursos' => 'required|array',
            'cursos.*' => 'exists:cursos,id',
            'documentos' => 'nullable|array',
            'documentos.*' => 'exists:documentos,id',

        ]);

        // Cria o módulo
        $modulo = Modulo::create([
            'nomeModulo' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'duracaoHoras' => $validated['duracao_horas'],

        ]);

        // Associa aos cursos selecionados (pivot)
        $modulo->cursos()->sync($validated['cursos']);

        // Sincroniza documentos (se enviados)
        $modulo->documentos()->sync($validated['documentos'] ?? []);

        return back()->with('success', 'Módulo criado com sucesso!');
    }
    /**
     * Atualiza um módulo existente e sincroniza os cursos.
     */
    public function update(Request $request, $id)
    {
        $modulo = Modulo::findOrFail($id);

        $validated = $request->validate([
            'nomeModulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'duracaoHoras' => 'required|numeric|min:0',
            'cursos' => 'required|array',
            'cursos.*' => 'exists:cursos,id',
            'documentos' => 'nullable|array',
            'documentos.*' => 'exists:documentos,id',

        ]);

        // Atualiza dados do módulo
        $modulo->update([
            'nomeModulo' => $validated['nomeModulo'],
            'descricao' => $validated['descricao'] ?? null,
            'duracaoHoras' => $validated['duracaoHoras'],

        ]);

        // Sincroniza os cursos associados
        $modulo->cursos()->sync($validated['cursos']);

        // Sincroniza documentos (se enviados)
        $modulo->documentos()->sync($validated['documentos'] ?? []);

        return redirect()->back()->with('success', 'Módulo atualizado com sucesso!');
    }

    /**
     * Deleta um ou mais módulos, considerando IDs separados por vírgula.
     */
    public function deletar(Request $request)
    {


        $cursoId = $request->curso_id;
        $ids = array_map('intval', explode(',', $request->ids));

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Nenhum módulo selecionado.');
        }

        if ($cursoId) {
            $curso = Curso::find($cursoId);

            if (!$curso) {
                return redirect()->back()->with('error', 'Curso não encontrado.');
            }

            // Remove a associação do curso aos módulos selecionados
            $curso->modulos()->detach($ids);

            // Para cada módulo, verifica se ainda tem cursos associados
            $modulos = Modulo::whereIn('id', $ids)->get();

            foreach ($modulos as $modulo) {

                // Aqui: só deleta se não tiver mais nenhum curso associado
                if ($modulo->cursos()->count() === 0) {
                    //dd($modulo);
                    // $modulo->delete();
                    $modulo->where('id', $modulo->id)->delete();
                }
            }

            return redirect()->route('modulos')->with('success', 'Associação(s) removida(s) e módulos órfãos apagados com sucesso!');
        }

        // Se não houver curso_id, apagar os módulos globalmente
        $modulos = Modulo::whereIn('id', $ids)->get();
        foreach ($modulos as $modulo) {
            // remove todas associações
            $modulo->cursos()->detach();
            $modulo->delete();
        }

        return redirect()->route('modulos')->with('success', 'Módulo(s) eliminado(s) com sucesso!');
    }


    //função para o calendario para filtrar modulos por curso
    public function byCurso($cursoId)
    {
        // N↔N: filtra módulos que estejam ligados ao curso via pivot
        $mods = Modulo::whereHas('cursos', function ($q) use ($cursoId) {
            $q->where('cursos.id', $cursoId);
        })
            ->orderBy('nomeModulo')
            ->get(['id', 'nomeModulo']); // cursos_id já não interessa

        // devolve JSON no formato esperado pelo teu JS
        return response()->json($mods);
    }



    public function documentosComAssociacao($moduloId)
    {
        $modulo = Modulo::join('curso_modulo','modulos.id','modulo_id')
        ->join('cursos','cursos.id','curso_id')
        ->where('cursos.users_id',Auth::id())
        ->findOrFail($moduloId); // pega o módulo específico
        return $modulo->documentosComAssociacao(); // chama o método seguro do model
    }
}


