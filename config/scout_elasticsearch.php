<?php

return [
    'elasticsearch' => [
        'index' => env('ELASTICSEARCH_INDEX', 'laravel_scout'),

        'hosts' => [
            env('ELASTICSEARCH_HOST', 'localhost:9200'),
        ],

        'settings' => [
            'index' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
            ],
        ],
    ],
];
