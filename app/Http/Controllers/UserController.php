<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
    return 'ajajaja';
    /*try {
        return response()->json(User::all());
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }*/
}

}

