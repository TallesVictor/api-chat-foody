<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function cnpj($cnpj)
    {
        $json = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.receitaws.com.br/v1/cnpj/' . $cnpj);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $json = (curl_exec($ch));
        curl_close($ch);
        header('Content-type: application/json');
        echo $json;
    }
}
