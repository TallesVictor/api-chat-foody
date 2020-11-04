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
        $select = "SELECT * FROM restaurante WHERE cnpj = '$request->cnpj'";
        $select = DB::select($select);
        if (!$select) {
            $proprietario = $request->proprietario;
            $razao_social = $request->razao_social;
            $cnpj = preg_replace('/[^0-9]/', '', $request->cnpj);
            $telefone = $request->telefone;
            $cep = preg_replace('/[^0-9]/', '', $request->cep);
            $estado = $request->estado;
            $cidade = $request->cidade;
            $rua = $request->rua;
            $numero = $request->numero;
            $complemento = $request->complemento;
            $descricao = $request->descricao;
            $usuario = $request->user;

            $insert = "INSERT INTO restaurante
                        (proprietario, razao_social, cnpj, telefone, cep, estado, cidade, rua, numero, complemento, descricao, user_id, created_at, updated_at)
                       VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW() )";
            return DB::insert($insert, [$proprietario, $razao_social, $cnpj, $telefone, $cep, $estado, $cidade, $rua, $numero, $complemento, $descricao, $usuario]);
        }
        return null;
    }

    public function search($parametro)
    {
        $select = "SELECT * FROM restaurante WHERE cnpj like '%$parametro%' LIMIT 1";
        $select = DB::select($select);
        if (!$select) {
            $select = "SELECT * FROM restaurante WHERE razao_social like '%$parametro%' LIMIT 1";
            return  DB::select($select);
        }
        return $select[0];
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
