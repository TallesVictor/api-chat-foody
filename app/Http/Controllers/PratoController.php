<?php

namespace App\Http\Controllers;

use App\Models\Prato;
use Illuminate\Http\Request;

class PratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $prato = new Prato();
        $prato = $prato->create($request);
        return $prato;
    }
    public function list($id)
    {
        $prato = new Prato();
        $prato = $prato->list($id);
        if ($prato) {
            return response()
                ->json($prato);
        }
        response('Prato não encontrado', 404);
    }

    public function listSearch($id)
    {
        $prato = new Prato();
        $prato = $prato->listSearch($id);
        if ($prato) {
            return response()
                ->json($prato);
        }
        response('Prato não encontrado', 404);
    }

    public function listItens($id)
    {
        $prato = new Prato();
        $prato = $prato->listItens($id);
        if(!$prato){
            return response('Prato não encontrado', 404);
        }
        return response()->json($prato);
    }

    public function deleteIngrediente($id, $ingrediente)
    {
        $prato = new Prato();
        $prato = $prato->deleteIngrediente($id, $ingrediente);
        return response()->json($prato);
    }

    public function del($id)
    {
        $prato = new Prato();
        $prato = $prato->del($id);
        return response()->json($prato);
    }
}
