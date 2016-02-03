<?php

return [
    'dependencies' => [
        'factories' => [
            Api\Helper\ApiMiddleware::class      => Api\Helper\ApiMiddlewareFactory::class,
            Api\V1\User\UserResource::class      => Api\V1\User\UserResourceFactory::class,
        ],
    ],
    'middleware_pipeline' => [
        'routing' => [
            'middleware' => [
                Api\Helper\ApiMiddleware::class
            ],
        ],
    ],
    'routes' => [
        [
            'name'            => 'user',
            'path'            => '/user[/{id:\d+}]',
            'middleware'      => Api\V1\User\UserResource::class,
            'allowed_methods' => ['GET', 'POST', 'PATCH'],
        ],
    ],
];
