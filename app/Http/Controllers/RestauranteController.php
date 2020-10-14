<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    public function insert(Request $request){
        $restaurante = new Restaurante();
        $restaurante = $restaurante->insert($request);
    }
}
