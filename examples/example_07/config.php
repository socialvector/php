<?php
/**
 * Build a configuration array to pass to `SocialVector\Hybridauth`
 *
 * Set the Authorization callback URL to https://path/to/socialvector/examples/example_07/callback.php
 * Understandably, you need to replace 'path/to/socialvector' with the real path to this script.
 */
$config = [
    'callback' => 'https://path/to/socialvector/examples/example_07/callback.php',
    'providers' => [

        'Google' => [
            'enabled' => true,
            'keys' => [
                'id' => '...',
                'secret' => '...',
            ],
            'scope' => 'email',
        ],

        // 'Yahoo' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
        // 'Facebook' => ['enabled' => true, 'keys' => ['id' => '...', 'secret' => '...']],
        // 'Spaces' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
        // 'Twitter' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
        // 'Instagram' => ['enabled' => true, 'keys' => ['id' => '...', 'secret' => '...']],

    ],
];
