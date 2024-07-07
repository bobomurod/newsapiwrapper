<?php

namespace App\Gateways;

use Illuminate\Support\Facades\Http;

class NewsApiGateway
{
    /**
     * Sends an HTTP request using the specified method to the given URL.
     *
     * @param string $method The HTTP method to use for the request (e.g., "POST" or "GET").
     * @param mixed $data The data to be sent with the request (only used for POST requests).
     * @param string $url The URL to send the request to.
     * @return array The decoded JSON response as an associative array.
     */
    public static function dragon($method, $data = null, $url)
    {
        if ($method == "POST")
            $result = Http::post($url,$data);
        else if($method == "GET")
            $result = Http::get($url);
        return json_decode($result->body(), true);
    }
}
