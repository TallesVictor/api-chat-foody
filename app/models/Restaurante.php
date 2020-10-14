<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Restaurante extends Model
{
    protected $table = "cardapio";
    protected $fillable = [
        "id", "proprietario", "razao_social", "cnpj",
        "telefone", "cep", "estado", "cidade", "rua", "numero", "complemento", "descricao", "created_at", "updated_at"
    ];

    public function insert(Request $request)
    {
        $json= $request->all();
        dd($json);
        // $proprietario = $request->proprietario;
        // $razao_social = $request->razao_social;
        // $cnpj = $request->cnpj;
        // $telefone = $request->telefone;
        // $cep = $request->cep;
        // $estado = $request->estado;
        // $cidade = $request->cidade;
        // $rua = $request->rua;
        // $numero = $request->numero;
        // $complemento = $request->complemento;
        // $descricao = $request->descricao;
        // $created_at = $request->created_at;
        // $updated_at = $request->updated_at;

        // $insert= "INSERT INTO cardapio VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW() )";
        // return DB::insert($insert, [$proprietario, $razao_social, $cnpj, $telefone, $cep, $estado, $cidade, $rua, $numero, $complemento, $descricao]);
    }
}
