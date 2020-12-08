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
        $prato = new Prato($request->all());
        $prato->valor = $prato->preco;
        $prato->ingredientes = $request->ingredientes;

        return response()
            ->json($prato);
    }

    public function atualizar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
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
        $prato = Prato::find($request->id);
        $prato->update($request->all());

        Prato::saveIngrediente($request->ingredientes, $prato->id);
        $prato = new Prato($request->all());
        $prato->valor = $prato->preco;
        $prato->ingredientes = $request->ingredientes;


        return response()
            ->json($prato);
    }

    public function list($id)
    {
        $pratoAll = array();
        $select = DB::select("SELECT id FROM prato WHERE cardapio_id=?", [$id]);

        for ($i = 0; $i < count($select); $i++) {


            $selIngrediente = " SELECT i.nome as ingrediente
                                FROM prato p
                                JOIN ingrediente i ON p.id = i.prato_id
                                WHERE p.id=?";
            $selIngrediente = DB::select($selIngrediente, [$select[$i]->id]);
            $ingredientes = [];

            foreach ($selIngrediente as $result) {
                $ingredientes[] = $result->ingrediente;
            }

            $prato = "SELECT p.id, p.nome, p.preco valor, p.url FROM prato p WHERE p.id=?";
            $prato = DB::select($prato, [$select[$i]->id]);
            if ($prato) {
                $prato[0]->ingredientes = $ingredientes;
            }
            array_push($pratoAll, (object) $prato[0]);
        }
        return  $pratoAll;
    }

    public function listSearch($search)
    {
        $pratoAll = array();
        $select = "SELECT  p.id
        FROM cardapio c LEFT JOIN prato p ON c.id = p.cardapio_id
        WHERE c.nome LIKE '%$search%'
        OR c.descricao LIKE '%$search%' OR  p.nome LIKE '%$search%'";
        $select = DB::select($select);
        for ($i = 0; $i < count($select); $i++) {
            $selIngrediente = " SELECT i.nome as ingrediente
                                FROM prato p
                                JOIN ingrediente i ON p.id = i.prato_id
                                WHERE p.id=? LIMIT 3";
            $selIngrediente = DB::select($selIngrediente, [$select[$i]->id]);
            $ingredientes = [];

            foreach ($selIngrediente as $result) {
                $ingredientes[] = $result->ingrediente;
            }

            $prato = "SELECT  r.razao_social restaurante, c.nome cardapio, p.id prato_id, p.nome, p.preco, p.url FROM prato p JOIN cardapio c ON c.id= p.cardapio_id JOIN restaurante r ON r.id = c.restaurante_id WHERE p.id=?";
            $prato = DB::select($prato, [$select[$i]->id]);
            if ($prato) {
                $prato[0]->ingredientes = $ingredientes;
            }
            array_push($pratoAll, (object) $prato[0]);
        }
        return  $pratoAll;
    }

    public function listSearchId($search)
    {
        $pratoAll = array();
        $search = json_decode($search);
        for ($j = 0; $j < count($search); $j++) {

            $select = "SELECT  p.id
                       FROM cardapio c LEFT JOIN prato p ON c.id = p.cardapio_id
                       WHERE p.id = ?";
            $select = DB::select($select, [$search[$j]]);
            for ($i = 0; $i < count($select); $i++) {
                $selIngrediente = " SELECT i.nome as ingrediente
                                FROM prato p
                                JOIN ingrediente i ON p.id = i.prato_id
                                WHERE p.id=? LIMIT 3";
                $selIngrediente = DB::select($selIngrediente, [$select[$i]->id]);
                $ingredientes = [];

                foreach ($selIngrediente as $result) {
                    $ingredientes[] = $result->ingrediente;
                }

                $prato = "SELECT  r.razao_social restaurante, c.nome cardapio, p.id prato_id, p.nome, p.preco, p.url, r.telefone FROM prato p JOIN cardapio c ON c.id= p.cardapio_id JOIN restaurante r ON r.id = c.restaurante_id WHERE p.id=?";
                $prato = DB::select($prato, [$select[$i]->id]);
                if ($prato) {
                    $prato[0]->ingredientes = $ingredientes;
                }
                array_push($pratoAll, (object) $prato[0]);
            }
        }
        return  $pratoAll;
    }

    public function listItens($id)
    {
        $selIngrediente = "SELECT i.nome as ingrediente
                    FROM prato p
                    JOIN ingrediente i ON p.id = i.prato_id
                    WHERE p.id=?";
        $selIngrediente = DB::select($selIngrediente, [$id]);
        $ingredientes = [];

        foreach ($selIngrediente as $result) {
            $ingredientes[] = $result->ingrediente;
        }

        $prato = "SELECT p.id, p.nome, p.preco as valor, p.url, r.razao_social restaurante, CONCAT(r.rua,'-', r.numero, ', ', r.cidade,'/', r.estado) endereco  FROM prato p JOIN cardapio c ON c.id= p.cardapio_id JOIN restaurante r ON r.id = c.restaurante_id WHERE p.id=?";
        $prato = DB::select($prato, [$id]);
        if ($prato) {
            $prato[0]->ingredientes = $ingredientes;
        }
        return  $prato[0];
    }

    private static function saveIngrediente($ingredientes, $id)
    {
        DB::delete("DELETE FROM ingrediente WHERE PRATO_ID = ?", [$id]);
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

    public static function apagar($id)
    {
        $delete = "DELETE FROM ingrediente WHERE prato_id = ?";
        DB::insert($delete, [$id]);
        $prato = Prato::find($id);
        return $prato->delete();
    }
}
