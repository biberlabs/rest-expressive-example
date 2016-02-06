<?php

return [
    'dependencies' => [
        'factories' => [
            Api\Helper\ApiMiddleware::class       => Api\Helper\ApiMiddlewareFactory::class,
            Api\V1\Mock\MockResource::class       => Api\V1\Mock\MockResourceFactory::class,
            Api\V1\User\UserResource::class       => Api\V1\User\UserResourceFactory::class,
            Api\V1\Address\AddressResource::class => Api\V1\Address\AddressResourceFactory::class,
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
            'name'            => 'mock',
            'path'            => '/mock[/{id:\w+}]',
            'middleware'      => Api\V1\Mock\MockResource::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'            => 'user',
            'path'            => '/user[/{id:\d+}]',
            'middleware'      => Api\V1\User\UserResource::class,
            'allowed_methods' => ['GET', 'POST', 'PATCH'],
        ],
        [
            'name'            => 'address',
            'path'            => '/address[/{id:\d+}]',
            'middleware'      => Api\V1\Address\AddressResource::class,
            'allowed_methods' => ['GET', 'POST', 'PATCH'],
        ],
    ],
];
