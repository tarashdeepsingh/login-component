<?php

return [
    'fields' => [
        'id' => ['type' => 'string', 'length' => 191, 'required' => true],
        'name' => ['type' => 'string', 'length' => 191, 'required' => true],
        'email' => ['type' => 'string', 'length' => 191, 'required' => true],
        'password' => ['type' => 'string', 'length' => 191, 'required' => true],
    ],

    'allow_emails' => true,

    'enable_language_selector' => true,

    'supported_languages' => [
        'en' => 'English',
        'fr' => 'French'
    ],

    'email_service_url' => env('EMAIL_SERVICE_URL', 'https://service-discovery.dataforall.org/v1/catalog/service/dfa_mailer'),
];
