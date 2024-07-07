<?php

namespace App\Services;

use App\Gateways\TranslateGateway;

class TranslateService
{
    public static function translate($source_lang = "en", $target_lang = "uz", $texts)
    {
        return TranslateGateway::dragon(
            "POST",
            [
                "source_language" => $source_lang,
                "target_language" => $target_lang,
                "texts" => $texts,
            ],
            "https://at.getcontainers.com/translate"
        );
    }
}
