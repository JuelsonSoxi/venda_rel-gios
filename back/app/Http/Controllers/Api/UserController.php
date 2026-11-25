
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'telefone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'] ?? null,
            'password' => Hash::make($validated['password']),
            'perfil' => 'cliente',
        ]);

        return response()->json([
            'message' => 'Utilizador cadastrado com sucesso!',
            'user' => $user,
        ], 201);
    }
}
