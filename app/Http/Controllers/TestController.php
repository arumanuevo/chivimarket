<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return response()->json(['message' => '¡Hola! Este es un mensaje de prueba.']);
    }
}
