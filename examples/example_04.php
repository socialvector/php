<?php
/*!
* A simple example that shows how to connect users to providers using OpenID.
*/

include 'vendor/autoload.php';

$config = [
    'callback' => SocialVector\HttpClient\Util::getCurrentUrl(),

    'keys' => ['id' => 'your-spaces-app-id', 'secret' => 'your-spaces-app-secret'],

    'endpoints' => [
        'api_base_url' => 'https://spacesnet.com//app_api',
        'authorize_url' => 'https://spacesnet.com/oauth',
        'access_token_url' => 'https://spacesnet.com/authorize',
    ]
];

try {
    $adapter = new SocialVector\Provider\Spaces($config);

    $adapter->setAccessToken(['access_token' => 'user-spaces-access-token']);

    $userProfile = $adapter->getUserProfile();

    // print_r($userProfile);

    $adapter->disconnect();
} catch (Exception $e) {
    echo $e->getMessage();
}
