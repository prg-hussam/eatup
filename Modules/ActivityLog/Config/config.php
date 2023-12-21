<?php

return [
    'modules' => [
        "users" => ["store", "destroy", "update", "login", 'reset_password_email'],
        "roles" => ["store", "destroy", "update"]
    ]
];
