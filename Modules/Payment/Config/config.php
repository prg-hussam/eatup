<?php

return [

    /**
     * Payment gateways api env
     * - test
     * - production
     *
     * @var string
     */
    "env" => env('PAYMENT_ENV', 'test'),

    'hyperpay' => [
        "test" => [
            "url" => "https://eu-test.oppwa.com",
            "access_token" => env('HYPERPAY_ACCESS_TOKEN'),
            'entity_id_visa_master' => env('HYPERPAY_ENTITY_ID_VISA_MASTER'),
            'entity_id_mada' => env('HYPERPAY_ENTITY_ID_MADA'),
        ],

        "production" => [
            "url" => "https://eu-prod.oppwa.com",
            "access_token" => env('HYPERPAY_ACCESS_TOKEN'),
            'entity_id_visa_master' => env('HYPERPAY_ENTITY_ID_VISA_MASTER'),
            'entity_id_mada' => env('HYPERPAY_ENTITY_ID_MADA'),
        ]
    ]
];
