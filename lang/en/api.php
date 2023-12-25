<?php


return [
    "auth" => [
        "attributes" => [
            "phone" => "Phone Number",
        ]
    ],

    "verifications" => [
        "attributes" => [
            "token" => "Token",
            "code" => "Code",
        ]
    ],


    'profile' => [
        "attributes" => [
            "name" => "Name",
            'ingredients' => 'ingredients',
            'ingredients.*' => 'ingredients',
        ]
    ],

    'messages' => [
        'verification_code_is_invalid' => 'The entered verification code is invalid. Please double-check the code and try again.',
        'customer_created_successfully' => 'Congratulations! Your account has been created successfully. Welcome to :app_name!',
        'account_inactive' => 'Your account is currently inactive. Please contact support for assistance.',
        'customer_logged_in_successfully' => 'Welcome back! You have successfully logged in to your account.'
    ]
];