<?php

return [
    'models' => [
        'user' => '\App\User',
    ],
    'auth' => [
        'guard' => 'api',
        'remember' => true,
    ],
];
