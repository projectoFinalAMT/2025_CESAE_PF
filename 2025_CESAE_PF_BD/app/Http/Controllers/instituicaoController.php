<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class instituicaoController extends Controller
{
    public function index(){
        $instituicoes = Instituicao::where('users_id',Auth::id())->get();
        return view('Instituicoes.instituicoes_home', compact('instituicoes'));
}

public function store(Request $request)
    {
        // dd($request->all());
        // Validação simples
        $validated = $request->validate([
           'nomeInstituicao'     => 'required|string|max:255',
            'morada'              => 'nullable|string',
            'NIF'                 => 'nullable|string|max:20',
            'telefoneResponsavel' => 'nullable|string|max:20',
            'emailResponsavel'    => 'required|email',
            'nomeResponsavel'     => 'nullable|string|max:255',
            'cor'            => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/', // validação simples para HEX

        ]);

        // Criar registo
        $instituicao = new Instituicao($validated);
        $instituicao->users_id =Auth::id();
        $instituicao->save();

       $redirect = $request->input('redirect_to');

        if ($redirect === 'cursos') {
            return redirect()->route('cursos')
                             ->with('success', 'Instituição criada com sucesso!');
        } elseif ($redirect === 'financas') {
            return redirect()->route('financas')
                             ->with('success', 'Instituição criada com sucesso!');
        }

        return redirect()->route('instituicoes')
                         ->with('success', 'Instituição criada com sucesso!');
    }



    public function deletar(Request $request)
{
    $ids = explode(',', $request->ids);
    Instituicao::whereIn('id', $ids)->delete();
    return redirect()->route('instituicoes')->with('success', 'Instituição eliminada com sucesso!');
}

public function update(Request $request, $id)
{
    // Buscar a instituição
    $instituicao = Instituicao::findOrFail($id);

    // Validação
    $validated = $request->validate([
        'nomeInstituicao'     => 'required|string|max:255',
        'morada'              => 'nullable|string',
        'NIF'                 => 'nullable|string|max:20',
        'telefoneResponsavel' => 'nullable|string|max:20',
        'emailResponsavel'    => 'required|email',
        'nomeResponsavel'     => 'nullable|string|max:255',
        'cor'                 => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/', // valida HEX

    ]);

    // Atualizar os campos
    $instituicao->update($validated);

    return redirect()->route('instituicoes')
                     ->with('success', 'Instituição atualizada com sucesso!');
}

public function buscar(Request $request)
{
    $query = $request->input('q'); // pega o texto digitado
    $instituicoes = Instituicao::where('nomeInstituicao', 'like', "%{$query}%")->get();

    // Retorna JSON
    return response()->json($instituicoes);
}

}
