<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function store(Request $request)
    {


        // Validação dos dados
        $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'telefone' => 'required|string|max:20',
    'password' => 'required|string|min:6|confirmed',
], [
    'email.unique' => 'Este email já está registado.',
    'password.confirmed' => 'A confirmação da password não coincide.',
]);

        // Criação do utilizador
        $user = User::create([
            'name' => $validated['name'],
            'dataNascimento' => $validated['dataNascimento'] ?? null,
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'password' => Hash::make($validated['password']),
            'photo'    => $validated['photo'] ?? null
        ]);



        return redirect()->route('login')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function update(Request $request, User $user)
{

    // Validação
    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email,' . $user->id . ',id',
        'telefone'  => 'required|string|max:255',
        'dataNascimento' => 'nullable|date',
    ], [
        'email.unique' => 'Este email já está registado.',
    ]);

      if($request->hasFile('photo')){
        $user->photo = Storage::putFile('documentos', $request->photo);

        }

    // Atualizar dados
    $user->name           = $validated['name'];
    $user->email          = $validated['email'];
    $user->telefone       = $validated['telefone'];
    $user->dataNascimento = $validated['dataNascimento'] ?? $user->dataNascimento;




    $user->save();

    return redirect()->route('casa')
        ->with('success', 'Usuário atualizado com sucesso!');
}

}




