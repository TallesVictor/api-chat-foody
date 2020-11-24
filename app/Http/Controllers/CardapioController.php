<?php

namespace App\Http\Controllers;

use App\models\Cardapio;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search($restaurante, $codigo, $nomeCardapio)
    {
        $cardapio = new Cardapio();
        $cardapio = $cardapio->search($codigo, $nomeCardapio, $restaurante);

        if (!$cardapio) {
            return response('Cardapio não encontrado', 404);
        }
        return response()
            ->json($cardapio);
    }

    public function list()
    {
        $cardapio = new Cardapio();
        $cardapio = $cardapio->list();

        if (!$cardapio) {
            return response('Cardapio não encontrado', 404);
        }
        return response()
            ->json($cardapio);
    }

    public function apagar($codigo)
    {
        $cardapio = new Cardapio();
        $cardapio = $cardapio->apagar($codigo);

        if (!$cardapio) {
            return response('Cardapio não encontrado', 404);
        }
        return response()
            ->json($cardapio);
    }

    public function alterar(Request $request)
    {
        $cardapio = new Cardapio();
        $cardapio = $cardapio->alterar($request);

        if (!$cardapio) {
            return response('Cardapio não encontrado', 404);
        }
        return response()
            ->json($cardapio);
    }

    public function insert(Request $request)
    {
        $cardapio = new Cardapio();
        $cardapio = $cardapio->insert($request);

        if (!$cardapio) {
            return true;
        }
        return response()
            ->json($cardapio);
    }
}
