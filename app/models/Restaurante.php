<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Restaurante extends Model
{
    protected $table = "restaurante";

    protected $fillable = [
        "id", "proprietario", "razao_social", "cnpj",
        "telefone", "cep", "estado", "cidade", "rua", "numero", "complemento", "descricao", "created_at", "updated_at"
    ];

    protected $hidden = ["created_at"];

    public function insert(Request $request)
    {
        $proprietario = $request->proprietario;
        $razao_social = $request->razao_social;
        $cnpj = $request->cnpj;
        $telefone = $request->telefone;
        $cep = $request->cep;
        $estado = $request->estado;
        $cidade = $request->cidade;
        $rua = $request->rua;
        $numero = $request->numero;
        $complemento = $request->complemento;
        $descricao = $request->descricao;
        $usuario = $request->usuario;


        $insert = "INSERT INTO restaurante
         (proprietario, razao_social, cnpj, telefone, cep, estado, cidade, rua, numero, complemento, descricao, user_id, created_at, updated_at)
         VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW() )";
        return DB::insert($insert, [$proprietario, $razao_social, $cnpj, $telefone, $cep, $estado, $cidade, $rua, $numero, $complemento, $descricao, $usuario]);
    }

    public function search($parametro)
    {
        $select = "SELECT * FROM restaurante WHERE cnpj like '%$parametro%'";
        $select = DB::select($select);
        if (!$select) {
            $select = "SELECT * FROM restaurante WHERE razao_social like '%$parametro%' ";
            return  DB::select($select);
        }
        return $select;
    }

    public function list()
    {
        return  Restaurante::all();
    }

    public function alterar(Request $request)
    {
        $id = $request->codigo;
        $restaurante = Restaurante::find($id);

        $restaurante->proprietario = $request->proprietario;
        $restaurante->razao_social = $request->razao_social;
        $restaurante->cnpj = $request->cnpj;
        $restaurante->telefone = $request->telefone;
        $restaurante->cep = $request->cep;
        $restaurante->estado = $request->estado;
        $restaurante->cidade = $request->cidade;
        $restaurante->rua = $request->rua;
        $restaurante->numero = $request->numero;
        $restaurante->complemento = $request->complemento;
        $restaurante->descricao = $request->descricao;
        $restaurante->updated_at = date('Y-m-d');

        return $restaurante->save();
    }

    public function apagar($codigo)
    {
        return Restaurante::where('id', $codigo)->delete();
    }
}
