<?php
/**
 * A simple example that shows how to use multiple providers.
 */

include 'vendor/autoload.php';
include 'config.php';

use SocialVector\Exception\Exception;
use SocialVector\Hybridauth;
use SocialVector\HttpClient;
use SocialVector\Storage\Session;

try {
    /**
     * Feed configuration array to Hybridauth.
     */
    $hybridauth = new Hybridauth($config);

    /**
     * Initialize session storage.
     */
    $storage = new Session();

    /**
     * Hold information about provider when user clicks on Sign In.
     */
    if (isset($_GET['provider'])) {
        $storage->set('provider', $_GET['provider']);
    }

    /**
     * When provider exists in the storage, try to authenticate user and clear storage.
     *
     * When invoked, `authenticate()` will redirect users to provider login page where they
     * will be asked to grant access to your application. If they do, provider will redirect
     * the users back to Authorization callback URL (i.e., this script).
     */
    if ($provider = $storage->get('provider')) {
        $hybridauth->authenticate($provider);
        $storage->set('provider', null);
    }

    /**
     * This will erase the current user authentication data from session, and any further
     * attempt to communicate with provider.
     */
    if (isset($_GET['logout'])) {
        $adapter = $hybridauth->getAdapter($_GET['logout']);
        $adapter->disconnect();
    }

    /**
     * Redirects user to home page (i.e., index.php in our case)
     */
    HttpClient\Util::redirect('https://path/to/socialvector/examples/example_06');
} catch (Exception $e) {
    echo $e->getMessage();
}
