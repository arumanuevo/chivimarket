<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use Illuminate\Http\Request;

class TransaccionController extends Controller
{
    public function index()
    {
        return Transaccion::all();
    }

    public function store(Request $request)
    {
        $transaccion = Transaccion::create($request->all());
        return response()->json($transaccion, 201);
    }

    public function show(Transaccion $transaccion)
    {
        return $transaccion;
    }

    public function update(Request $request, Transaccion $transaccion)
    {
        $transaccion->update($request->all());
        return response()->json($transaccion, 200);
    }

    public function delete(Transaccion $transaccion)
    {
        $transaccion->delete();
        return response()->json(null, 204);
    }
}
