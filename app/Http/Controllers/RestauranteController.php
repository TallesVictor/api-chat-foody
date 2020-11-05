<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\User;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    public function insert(Request $request)
    {
        $restaurante = new Restaurante();
        $restaurante = $restaurante->insert($request);
        if (!$restaurante) {
            return response('Restaurante não encontrado', 404);
        }
        return response()->json($restaurante);
    }

    public function search($parametro)
    {
        $restaurante = new Restaurante();
        $restaurante = $restaurante->search($parametro);
        if (!$restaurante) {
            return response('Restaurante não encontrado', 404);
        }
        return response()->json($restaurante);
    }

    public function list()
    {
        $restaurante = new Restaurante();
        $restaurante = $restaurante->list();
        if (!$restaurante) {
            return response('Restaurante não encontrado', 404);
        }
        return response()->json($restaurante);
    }

    public function alterar(Request $request)
    {
        $user = $request->user()->id;

        $restaurante = new Restaurante();
        $restaurante = $restaurante->alterar($request, $user);
        if (!$restaurante) {
            return response('Erro ao alterar restaurante', 404);
        }
        return response()->json($restaurante);
    }

    public function apagar(Request $request)
    {
        $codigo = $request->user()->id;
        $restaurante = new Restaurante();
        $restaurante = $restaurante->apagar($codigo);
        if (!$restaurante) {
            return response('Restaurante não encontrado', 404);
        }
        return response()->json($restaurante);
    }

    public function restaurante(Request $request)
    {
        $restaurante = new Restaurante();
        $restaurante = $restaurante->search($request->user()->id);
        if (!$restaurante) {
            return response('Restaurante não encontrado', 404);
        }
        return response()->json($restaurante);
    }
}
