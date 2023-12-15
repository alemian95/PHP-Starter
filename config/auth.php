<?php

return [
    'default' => 'web',
    'guards' => [
        'web' => [
            'provider' => 'users',
            'identifier' => 'email',
            'secret' => 'password',
        ],
        'cpa' => [
            'provider' => 'admins',
            'identifier' => 'email',
            'secret' => 'password',
        ]
    ]
];