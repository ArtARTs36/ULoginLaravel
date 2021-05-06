<?php

return [
    'models' => [
        /** @see \ArtARTs36\ULoginLaravel\Contracts\User */
        'user' => '\App\User',
    ],
    'auth' => [
        'guard' => 'api',
        'remember' => true,
    ],
];
