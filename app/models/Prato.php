<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Prato extends Model
{
    protected $table = "prato";
    protected $fillable = ['id', 'nome', 'preco', 'cardapio_id', 'url', 'created_at', 'updated_at'];
    protected $hidden = ['id', 'cardapio_id', 'created_at', 'updated_at'];

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nome' => 'required|string',
                'preco'     => 'required|numeric',
                'cardapio_id'      => 'required|numeric',
                'ingredientes'      => 'required|array|min:1',
            ]
        );

        if ($validator->fails()) {
            $erro = (object)[];
            $erro->erro = $validator->errors();
            return response()
                ->json($erro);
        }

        if (!$request->url) {
            $request->url = null;
        }

        $request->created_at = date('Y-m-d');
        $request->updated_at = date('Y-m-d');

        $prato = new Prato($request->all());
        $prato->save();

        Prato::saveIngrediente($request->ingredientes, $prato->id);

        return response()
            ->json($request->all());
    }

    public function list($id)
    {
        // $select = "SELECT p.nome, p.preco FROM prato p JOIN cardapio c ON c.id = p.cardapio_id WHERE c.id=?";
        // $select = DB::select($select, [$id]);
        // return $select;

        $selIngrediente = " SELECT i.nome as ingrediente
        FROM prato p
        JOIN ingrediente i ON p.id = i.prato_id
        JOIN cardapio c ON c.id = p.cardapio_id
        WHERE c.id=?";
        $selIngrediente = DB::select($selIngrediente, [$id]);
        $ingredientes = [];

        foreach ($selIngrediente as $result) {
            $ingredientes[] = $result->ingrediente;
        }

        $prato = "SELECT p.nome, p.preco, p.url FROM prato p WHERE p.id=?";
        $prato = DB::select($prato, [$id]);
        if ($prato) {
            $prato[0]->ingredientes = $ingredientes;
        }
        return  $prato;
    }

    public function listItens($id)
    {
        $selIngrediente = " SELECT i.nome as ingrediente
                    FROM prato p
                    JOIN ingrediente i ON p.id = i.prato_id
                    WHERE p.id=?";
        $selIngrediente = DB::select($selIngrediente, [$id]);
        $ingredientes = [];

        foreach ($selIngrediente as $result) {
            $ingredientes[] = $result->ingrediente;
        }

        $prato = "SELECT p.nome, p.preco, p.url FROM prato p WHERE p.id=?";
        $prato = DB::select($prato, [$id]);
        if ($prato) {
            $prato[0]->ingredientes = $ingredientes;
        }
        return  $prato;
    }

    private static function saveIngrediente($ingredientes, $id)
    {
        for ($i = 0; $i < count($ingredientes); $i++) {
            $insert = "INSERT INTO ingrediente (NOME, PRATO_ID, CREATED_AT, UPDATED_AT) VALUES (?, ?, NOW(), NOW())";
            DB::insert($insert, [$ingredientes[$i], $id]);
        }
    }

    public static function deleteIngrediente($prato, $ingrediente)
    {
        $delete = "DELETE FROM ingrediente WHERE nome = ? AND prato_id = ?";
        return  DB::insert($delete, [$ingrediente, $prato]);
    }

    public static function del($id)
    {
        $delete = "DELETE FROM ingrediente WHERE prato_id = ?";
        DB::insert($delete, [$id]);
        $prato = Prato::find($id);
        return $prato->delete();
    }
}
