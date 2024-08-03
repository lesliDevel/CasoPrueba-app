<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    //DE ESTA MANERA LISTAMOS LOS REGISTROS DE USER
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
// Método para registrar un nuevo usuario
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Registro fallido,intentelo otra vez', 'errors' => $validator->errors()], 400);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['message' => 'Registro exitoso', 'user' => $user], 201);
}

// Método para iniciar sesión
public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Autenticación fallida', 'errors' => $validator->errors()], 400);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    // Generar un token simple para el usuario
    $token = Str::random(60);

    // Devolver el token en la respuesta
    return response()->json(['message' => 'Autenticación exitosa', 'token' => $token], 200);
}




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
