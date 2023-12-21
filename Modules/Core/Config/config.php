<?php

return [

    "enable_domain" => env('ROUTE_ENABLE_DOMAIN', false),

    "routes" => [
        "web" => [
            "main" => [
                "domain" =>  env('PUBLIC_DOMAIN', "localhost"),
                "file" => "public.php",
                "middleware" => []
            ],
            "admin" => [
                "domain" => env('ADMIN_DOMAIN', "admin.localhost"),
                "prefix" => "admin",
                "namespace" => "Admin",
                "middleware" => ['auth:web', 'lockScreen'],
                "file" => "admin.php",
                "name" => "admin."
            ],
        ],
        "api" => [
            [
                "domain" => env('API_DOMAIN', "api.localhost"),
                "prefix" => "api",
                "sub_prefix" => "v1",
                "namespace" => "Api\\V1",
                "middleware" => ['api'],
                "file" => "api/v1.php"
            ],
        ]
    ]
];
