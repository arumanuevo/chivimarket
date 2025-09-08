<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NegocioController extends Controller
{
    public function index()
    {
        return Negocio::all();
    }

    public function store(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Log para verificar el usuario
        \Log::info('Usuario autenticado:', ['user' => $user]);

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Crear el negocio con el user_id del usuario autenticado
        $negocio = Negocio::create([
            'user_id' => $user->id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud
        ]);

        return response()->json($negocio, 201);
    }


    public function show(Negocio $negocio)
    {
        return $negocio;
    }

    public function update(Request $request, Negocio $negocio)
    {
        $negocio->update($request->all());
        return response()->json($negocio, 200);
    }

    public function destroy(Negocio $negocio)
    {
        $negocio->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtiene todos los negocios del usuario autenticado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function misNegocios()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Obtener los negocios del usuario con paginación
        $negocios = Negocio::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($negocios);
    }
}

