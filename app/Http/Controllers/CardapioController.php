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
    public function teste(Request $request)
    {
        $json= $request->all();
        if(!$json){
           return response('JSON Inválido', 401);
        }
        dd($json);
    }
}
