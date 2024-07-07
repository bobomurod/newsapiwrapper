<?php

namespace App\Gateways;

use Illuminate\Support\Facades\Http;

class TranslateGateway
{

    public static function dragon($method, $data = null, $url)
    {
        /*$data = json_encode($data,true);*/

        if ($method == "POST")
            $result = Http::post($url,$data);
        else if($method == "GET")
            $result = Http::get($url);
        return json_decode($result->body(), true);
    }
}
