<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Documento;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class documentoController extends Controller
{
public function index()
{
    $instituicoes = Instituicao::where('users_id',Auth::id())->get();

    $documentos = Documento::
    where('users_id',Auth::id())->with('modulos')->get();

    $modulos = Modulo::join('curso_modulo','modulos.id','modulo_id')
    ->join('cursos','cursos.id','curso_id')
    ->where('users_id',Auth::id())
    ->with('cursos.instituicao')
        ->select('modulos.id', 'nomeModulo')
        ->distinct()
        ->orderBy('nomeModulo')
        ->get();

    $cursos = Curso::where('users_id',Auth::id())->withCount('modulos')->get();

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

$documentosPessoais = Documento::where('users_id',Auth::id())->with('categoria')
    ->where('users_id', Auth::id())
    ->whereHas('categoria', fn($q) => $q->where('categoria', 'pessoal'))
    ->get();

$documentosApoio = Documento::where('users_id',Auth::id())->with('categoria')
    ->where('users_id', Auth::id())
    ->whereHas('categoria', fn($q) => $q->where('categoria', 'apoio'))
    ->get();




    return view('documentos.documentos_home', compact(
        'cursos', 'instituicoes', 'modulos', 'cursoModulos',
        'documentosApoio', 'documentosPessoais', 'DocumentoModuloIds'
    ));
}

public function store(Request $request)
{

    $validated = $request->validate([
        'arquivo_documento' => 'nullable|file|mimes:pdf,docx,jpg,png|max:10240',
        'link_documento'    => 'nullable|url',
        'modulos'           => 'nullable|array',
        'modulos.*'         => 'exists:modulos,id',

    ]);

    if (!$request->hasFile('arquivo_documento') && !$request->filled('link_documento')) {
        return back()->withErrors(['arquivo_documento' => 'Envie um arquivo ou informe um link.']);
    }

    $nome = $request->tipo === 'pessoal' ? $request->nome_pessoal : $request->nome_apoio;

    if ($request->hasFile('arquivo_documento')) {
        $file = $request->file('arquivo_documento');

        if (!$file->isValid()) {
            return back()->withErrors(['arquivo_documento' => 'Falha no upload do arquivo.']);
        }

        $ext = strtolower($file->getClientOriginalExtension());

        $publicDir = storage_path('app/public/documentos');
        if (!file_exists($publicDir)) mkdir($publicDir, 0777, true);

        // Caso seja pessoal e não seja PDF, converter
        if ($ext !== 'pdf' && $request->tipo === 'pessoal') {
            $tempDir = storage_path('app/temp_docs');
            if (!file_exists($tempDir)) mkdir($tempDir, 0777, true);

            // Cria um arquivo temporário com a extensão correta
            $tempRealFile = $tempDir . DIRECTORY_SEPARATOR . uniqid('upload_', true) . '.' . $file->getClientOriginalExtension();
            copy($file->getRealPath(), $tempRealFile);

            // $sofficePath = '"/Applications/LibreOffice.app/Contents/MacOS/soffice"';
             $sofficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';
            $command = $sofficePath . " --headless --convert-to pdf --outdir "
                . escapeshellarg($tempDir) . " " . escapeshellarg($tempRealFile);

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                unlink($tempRealFile);
                throw new \Exception("Erro ao converter documento para PDF. Saída LibreOffice: " . implode("\n", $output));
            }

            // Pega o PDF mais recente gerado
            $pdfFiles = glob($tempDir . DIRECTORY_SEPARATOR . '*.pdf');
            if (!$pdfFiles) {
                unlink($tempRealFile);
                throw new \Exception("PDF não encontrado após conversão. Saída LibreOffice: " . implode("\n", $output));
            }

            usort($pdfFiles, fn($a, $b) => filemtime($b) <=> filemtime($a));
            $generatedPdf = $pdfFiles[0];

            // Move para storage/public/documentos
            $finalPath = Storage::disk('public')->putFileAs('documentos', new \Illuminate\Http\File($generatedPdf), basename($generatedPdf));
            $caminho = 'storage/' . $finalPath;

            // Limpeza
            unlink($tempRealFile);
            unlink($generatedPdf);

        } else {

            $path= Storage::putFile('documentos', $request->arquivo_documento);
            // PDF existente ou arquivo não pessoal → salva direto
            // $path = $file->store('documentos', 'public');
            $caminho = 'storage/' . $path;
            //  dd($request->all());
        }

    } else {
        // Link externo
        $caminho = $request->input('link_documento');

    }
    // Categoria
    $categoriaId = DB::table('categoria_documentos')
        ->where('categoria', $request->tipo)
        ->value('id');

    $dataValidade = $request->vitalicio
        ? '9999-01-01'
        : ($request->dataValidade ?? '9999-01-01');

    $descricao = $request->input('descricao');
    // Cria o documento
    $documento = Documento::create([
        'nome' => $nome,
        'caminhoDocumento' => $caminho,
        'dataValidade' => $dataValidade,
        'categoria_documento_id' => $categoriaId,
        'descricao' => $descricao,
        'estado_documentos_id' => 1,
        'users_id' => Auth::id(),
    ]);

    // Associa módulos
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
