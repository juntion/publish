<?php

return [
    'name' => 'Tag',

    'signature' => [
        'token' => env('SIGNATURE_TOKEN', ''),
        'ttl' => env('SIGNATURE_TTL', 60 * 10),
    ],
];
