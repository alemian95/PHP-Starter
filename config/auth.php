<?php

return [
    'default_guard' => 'web',
    'guards' => [
        'web' => [
            'provider' => 'users',
            'identifier' => 'email',
            'secret' => 'password',
            'cookie' => [
                'name' => 'app_web_login',
                'expire' => 2592000
            ]
        ],
        'cpa' => [
            'provider' => 'admins',
            'identifier' => 'email',
            'secret' => 'password',
            'cookie' => [
                'name' => 'app_cpa_login',
                'expire' => 2592000
            ]
        ]
    ]
];