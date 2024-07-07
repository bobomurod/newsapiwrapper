<?php

namespace App\Services;

use App\Gateways\NewsApiGateway;

class NewsApiService
{
    /**
     * Fetches the top headlines from the News API.
     *
     * @return array The decoded JSON response from the News API containing the top headlines.
     */
    public static function topHeadlines()
    {
        return NewsApiGateway::dragon(
            "GET",
            null,
            "https://newsapi.org/v2/top-headlines?country=us&apiKey=".config("custom.apiKey")
        );
    }
}
