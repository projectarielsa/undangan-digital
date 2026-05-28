<?php

return [

    "postmark" => [
        "key" => env("POSTMARK_API_KEY")
    ],

    "ses" => [
        "key" => env("AWS_ACCESS_KEY_ID"),
        "secret" => env("AWS_SECRET_ACCESS_KEY"),
        "region" => env("AWS_DEFAULT_REGION", "us-east-1")
    ],

    "google" => [
        "client_id" => env("GOOGLE_CLIENT_ID"),
        "client_secret" => env("GOOGLE_CLIENT_SECRET"),

        // default redirect
        "redirect" => env(
            "GOOGLE_REDIRECT_URI",
            env("APP_URL") . "/auth/google/callback"
        ),

        // login dengan google
        "login_redirect" => env(
            "GOOGLE_LOGIN_REDIRECT_URI",
            env("APP_URL") . "/auth/google/callback"
        ),

        // daftar dengan google
        "register_redirect" => env(
            "GOOGLE_REGISTER_REDIRECT_URI",
            env("APP_URL") . "/register/google/callback"
        ),
    ],

    "midtrans" => [
        "server_key" => env("MIDTRANS_SERVER_KEY"),
        "client_key" => env("MIDTRANS_CLIENT_KEY"),
        "is_production" => env("MIDTRANS_IS_PRODUCTION", false),
        "snap_url" => env(
            "MIDTRANS_SNAP_URL",
            "https://app.sandbox.midtrans.com/snap/snap.js"
        )
    ],

];