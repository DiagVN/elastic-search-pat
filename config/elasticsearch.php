<?php

return [
    'connection' => [
        'host' => env('ELASTICSEARCH_HOST', 'https://elasticsearch:9200'),
        'user' => env('ELASTICSEARCH_USER', 'elastic'),
        'pass' => env('ELASTICSEARCH_PASS', 'secret'),
        'sslVerification' => env('ELASTICSEARCH_SSL_VERIFICATION', false),
        'bookingIndex' => env('ELASTICSEARCH_BOOKING_INDEX', 'pat-booking_v1'),
        'bookingAlias' => env('ELASTICSEARCH_BOOKING_ALIAS', 'pat-booking'),

    ],
];
