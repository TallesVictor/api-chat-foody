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

    public function search($parametro){
        $restaurante = new Restaurante();
        $restaurante = $restaurante->search($parametro);
        if(!$restaurante){
            return response('Restaurante não encontrado', 404);
        }
        return json_encode($restaurante);
    }

    public function list(){
        $restaurante = new Restaurante();
        $restaurante = $restaurante->list();
        if(!$restaurante){
            return response('Restaurante não encontrado', 404);
        }
        return json_encode($restaurante);
    }

    public function alterar(Request $request){
        $restaurante = new Restaurante();
        $restaurante = $restaurante->alterar($request);
        if(!$restaurante){
            return response('Restaurante não encontrado', 404);
        }
        return json_encode($restaurante);
    }

    public function apagar($codigo){
        $restaurante = new Restaurante();
        $restaurante = $restaurante->apagar($codigo);
        if(!$restaurante){
            return response('Restaurante não encontrado', 404);
        }
        return json_encode($restaurante);
    }

}