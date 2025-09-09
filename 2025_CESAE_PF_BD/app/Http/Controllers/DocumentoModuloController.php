<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use App\Models\DocumentoModulo;

class DocumentoModuloController extends Controller
{
    public function index()
    {

        $documentoModulo = DocumentoModulo::all();
        return view('documentos.documentos_home', compact('documentoModulo'));
    }



 public function removerAssociacao(Request $request)
{
    $ids = $request->ids;

    if (empty($ids)) {
        return redirect()->back()->with('error', 'Nenhum documento selecionado.');
    }

    $idsArray = explode(',', $ids);

    foreach ($idsArray as $pivotId) {
        DocumentoModulo::where('id', $pivotId)->delete();
    }

    return redirect()->route('documentos')->with('success', 'Associações removidas com sucesso!');
}

}
