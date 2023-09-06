<?php

return [
    'app' => [
        'name'      => env('APP_NAME', 'Laravel'),
        'version'   => 'v0.1.0-alpha',
        'copyright' => '2023 All Rights Reserved',
    ],

    'company' => [
        'key'           => 'insm',
        'name'          => 'testing',
        'email'         => 'testing',
        'website'       => 'testing',
        'phone'         => 'testing',
        'address'       => 'testing',
        'city_id'       => 164,
    ],

    'logo' => [
        'favicon'       => '',
        'auth'          => '',
        'aside'         => '',
        'print'         => '',
        'barcode'       => '',
    ],

    'mail' => [
        'send' => env('MAIL_SEND_STATUS', false),
        'logo' => '',
    ],

    'custom-menu' => true,
];
