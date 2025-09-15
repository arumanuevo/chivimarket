<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    public function show(Producto $producto)
    {
        return $producto;
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($request->all());
        return response()->json($producto, 200);
    }

    public function delete(Producto $producto)
    {
        $producto->delete();
        return response()->json(null, 204);
    }
    
    public function productosPorNegocio($negocioId)
    {
        return Producto::where('negocio_id', $negocioId)->get();
    }

}
