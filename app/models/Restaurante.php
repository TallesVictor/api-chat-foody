<?php

namespace App\Models;

use App\Http\Controllers\AuthController;
use App\models\Cardapio;
use App\User;
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
        $select = "SELECT id, proprietario, razao_social, cnpj, telefone, cep, estado, cidade, rua, numero, complemento, descricao, updated_at FROM restaurante WHERE cnpj = '$request->cnpj'";
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
        $select = "SELECT r.id, proprietario, u.email, razao_social, cnpj, telefone, cep, estado, cidade, rua, numero, complemento, descricao, r.updated_at FROM restaurante r JOIN users u ON r.user_id = u.id WHERE r.user_id='$parametro' LIMIT 1";
        $select = DB::select($select);
        if (!$select) {
            $select = "SELECT id, proprietario, razao_social, cnpj, telefone, cep, estado, cidade, rua, numero, complemento, descricao, updated_at FROM restaurante WHERE cnpj like '%$parametro%' LIMIT 1";
            $select = DB::select($select);
            if (!$select) {
                $select = "SELECT id, proprietario, razao_social, cnpj, telefone, cep, estado, cidade, rua, numero, complemento, descricao, updated_at FROM restaurante WHERE razao_social like '%$parametro%' LIMIT 1";
                return  DB::select($select);
            }
        }
        return $select[0];
    }

    public function list()
    {
        return  Restaurante::all();
    }

    public function alterar(Request $request, $user)
    {
        if ($request->senha && $request->senha != $request->confirmacao_senha) {
            return null;
        }
        $request->name = $request->proprietario;
        $cnpj = $request->cnpj;
        $restaurante = Restaurante::where('cnpj', $cnpj)->where('user_id', $user)->first();
        $restaurante->proprietario = $request->proprietario;
        $restaurante->razao_social = $request->razao_social;
        $restaurante->telefone = $request->telefone;
        $restaurante->cep =  preg_replace('/[^0-9]/', '', $request->cep);
        $restaurante->estado = $request->estado;
        $restaurante->cidade = $request->cidade;
        $restaurante->rua = $request->rua;
        $restaurante->numero = $request->numero;
        $restaurante->complemento = $request->complemento;
        $restaurante->descricao = $request->descricao;
        $restaurante->updated_at = date('Y-m-d');

        $restaurante->save();

        AuthController::edit($request);

        return $restaurante;
    }

    public function apagar($codigo)
    {
        $idRest = DB::table('restaurante')->where('user_id', $codigo)->value('id');
        echo $idRest;
        $cardapio = DB::table('cardapio')->where('restaurante_id', $idRest)->value('id');
        dd($cardapio);
        // foreach ($cardapio as $key) {
        //     echo $key->id;
        //     // Prato::where('cardapio_id', $key->id)->delete();
        // }
        // $restaurante->delete();
        // $cardapio->delete();
        // User::where('id', $codigo)->delete();

    }
}
