<?php
/**
 * Build a configuration array to pass to `SocialVector\Hybridauth`
 */

$config = [
    /**
     * Set the Authorization callback URL to https://path/to/socialvector/examples/example_06/callback.php.
     * Understandably, you need to replace 'path/to/socialvector' with the real path to this script.
     */
    'callback' => 'https://path/to/socialvector/examples/example_06/callback.php',
    'providers' => [
        'Twitter' => [
            'enabled' => true,
            'keys' => [
                'key' => '...',
                'secret' => '...',
            ],
        ],
        'LinkedIn' => [
            'enabled' => true,
            'keys' => [
                'id' => '...',
                'secret' => '...',
            ],
        ],
        'Facebook' => [
            'enabled' => true,
            'keys' => [
                'id' => '...',
                'secret' => '...',
            ],
        ],
    ],
];
