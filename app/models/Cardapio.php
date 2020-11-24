<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cardapio extends Model
{
    protected $table = "cardapio";
    protected $fillable = ['id', 'nome', 'descricao', 'restaurante_id', 'created_at', 'updated_at'];
    protected $hidden = ['restautante_id', 'created_at'];

    protected $idUsur = 0;

    function __construct()
    {
        $this->idUsur = Auth::id();
    }

    public function insert(Request $request)
    {
        $select = DB::select("SELECT id FROM restaurante WHERE user_id = ?", [$this->idUsur]);

        $cardapio = new Cardapio();

        $cardapio->nome = $request->nome;
        $cardapio->descricao = $request->descricao;
        $cardapio->restaurante_id = $select[0]->id;
        $cardapio->created_at = date('Y-m-d');
        $cardapio->updated_at = date('Y-m-d');

        $cardapio->save();
    }

    public function search($codigo, $cardapio, $restaurante)
    {
        $select = "SELECT c.nome, c.descricao FROM cardapio c JOIN restaurante r ON c.restaurante_id = r.id WHERE restaurante_id = ? AND nome=? AND r.razao_social=?";
        return DB::select($select, [$codigo,  $cardapio, $restaurante]);
    }

    public function list()
    {
        $select = "SELECT c.id, c.nome, c.descricao FROM cardapio c JOIN restaurante r ON c.restaurante_id = r.id WHERE user_id=?";
        return DB::select($select, [$this->idUsur]);
    }

    public function alterar(Request $request)
    {
        $id = $request->codigo;
        $cardapio = Cardapio::find($id);

        $cardapio->nome = $request->nome;
        $cardapio->descricao = $request->descricao;
        $cardapio->updated_at = date('Y-m-d');

        return $cardapio->save();
    }

    public function apagar($codigo)
    {
        $delete = "DELETE c.* FROM cardapio c JOIN restaurante r ON c.restaurante_id = r.id WHERE c.id = ? AND r.user_id = ?";
        return DB::delete($delete, [$codigo, $this->idUsur]);
    }
}
