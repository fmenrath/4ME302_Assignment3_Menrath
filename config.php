<?php
// Include Hybridauth's basic autoloader
include 'hybridauth/src/autoload.php';

$config = [
    // Location where to redirect users once they authenticate with a provider
    'callback' => 'http://xxx/home.php',

    // Providers specifics
    'providers' => [
        'Google' => [
            'enabled' => true, 
            'keys' => ['id' => 'xxx', 'secret' => 'xxx'],
            'scope'    => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
            'authorize_url_parameters' => [
                'approval_prompt' => 'force',
            ]
        ],
        'Twitter' => [
            'enabled' => true, 
            'keys' => ['id' => 'xxx', 'secret' => 'xxx'],
            'authorize_url_parameters' => [
                'approval_prompt' => 'force',
            ]
        ],
        'Github' => [
            'enabled' => true, 
            'keys' => ['id' => 'xxx', 'secret' => 'xxx'],
            'authorize_url_parameters' => [
                'approval_prompt' => 'force',
            ]
        ]
        ]
    ]
];



