<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Documento;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Models\FormatoDocumento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class documentoController extends Controller
{
public function index()
{
    $instituicoes = Instituicao::all();

    $documentos = Documento::with('modulos')->get();

    $modulos = Modulo::with('cursos.instituicao')
        ->select('id', 'nomeModulo')
        ->distinct()
        ->orderBy('nomeModulo')
        ->get();

    $cursos = Curso::withCount('modulos')->get();

    $cursoModulos = DB::table('curso_modulo')
        ->select('curso_id', 'modulo_id')
        ->get()
        ->groupBy('curso_id')
        ->map(fn($modulos) => $modulos->pluck('modulo_id')->toArray());

    // IDs das associações documentos-modulos
    $DocumentoModuloIds = [];
    foreach ($documentos as $doc) {
        foreach ($doc->modulos as $modulo) {
            $DocumentoModuloIds[$doc->id][$modulo->id] = $modulo->pivot->id ?? null;
        }
    }

    $documentosPessoais = Documento::with('formatoDocumento', 'categoria')
        ->whereHas('categoria', fn($q) => $q->where('categoria', 'pessoal'))
        ->get();

    $documentosApoio = Documento::with('formatoDocumento', 'categoria')
        ->whereHas('categoria', fn($q) => $q->where('categoria', 'apoio'))
        ->get();

    $formatoDocumento = FormatoDocumento::all();

    return view('documentos.documentos_home', compact(
        'cursos', 'instituicoes', 'modulos', 'cursoModulos',
        'documentosApoio', 'documentosPessoais', 'formatoDocumento', 'DocumentoModuloIds'
    ));
}





  public function store(Request $request)
{
    $validated = $request->validate([
        'arquivo_documento' => 'required|file|mimes:pdf,docx,jpg,png',
        'modulos' => 'nullable|array',
        'modulos.*' => 'exists:modulos,id',
    ]);

    $nome = $request->tipo === 'pessoal' ? $request->nome_pessoal : $request->nome_apoio;
    $tipo_documento = $request->tipo_documento;

    // Salvar arquivo
    $caminho = $request->file('arquivo_documento')->store('documentos');

    // Buscar IDs
    $categoriaId = \DB::table('categoria_documentos')
        ->where('categoria', $request->tipo)
        ->value('id');

    $formatoId = \DB::table('formato_documentos')
        ->whereRaw('LOWER(nomeFormato) = ?', [strtolower($tipo_documento)])
        ->value('id');

    $dataValidade = $request->vitalicio ? '9999-01-01' : ($request->dataValidade ?? now()->toDateString());

    $descricao = $request->input('descricao');

    // Criar documento
    $documento = Documento::create([
        'nome' => $nome,
        'caminhoDocumento' => $caminho,
        'dataValidade' => $dataValidade,
        'categoria_documento_id' => $categoriaId,
        'formato_documentos_id' => $formatoId,
        'descricao' => $descricao,
        'estado_documentos_id' => 1,
        'users_id' => Auth::id() ?? 1,
    ]);

    // Associa módulos selecionados
    if (!empty($validated['modulos'])) {
        $documento->modulos()->sync($validated['modulos']);
    }

    return redirect()->route('documentos')->with('success', 'Documento gravado com sucesso!');
}


    public function deletar(Request $request)
    {
        $ids = explode(',', $request->ids);
        Documento::whereIn('id', $ids)->delete();
        return redirect()->route('documentos')->with('success', 'Documento eliminado com sucesso!');
    }


}
