<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Adapter;

use SocialVector\HttpClient\HttpClientInterface;
use SocialVector\Storage\StorageInterface;
use SocialVector\Logger\LoggerInterface;

/**
 * Interface AdapterInterface
 */
interface AdapterInterface
{
    /**
     * Initiate the appropriate protocol and process/automate the authentication or authorization flow.
     *
     * @return bool|null
     */
    public function authenticate();

    /**
     * Returns TRUE if the user is connected
     *
     * @return bool
     */
    public function isConnected();

    /**
     * Clear all access token in storage
     */
    public function disconnect();

    /**
     * Retrieve the connected user profile
     *
     * @return \SocialVector\User\Profile
     */
    public function getUserProfile();

    /**
     * Retrieve the connected user contacts list
     *
     * @return \SocialVector\User\Contact[]
     */
    public function getUserContacts();

    /**
     * Retrieve the connected user pages|companies|groups list
     *
     * @return array
     */
    public function getUserPages();

    /**
     * Retrieve the user activity stream
     *
     * @param string $stream
     *
     * @return \SocialVector\User\Activity[]
     */
    public function getUserActivity($stream);

    /**
     * Post a status on user wall|timeline|blog|website|etc.
     *
     * @param string|array $status
     *
     * @return mixed API response
     */
    public function setUserStatus($status);

    /**
     * Post a status on page|company|group wall.
     *
     * @param string|array $status
     * @param string $pageId
     *
     * @return mixed API response
     */
    public function setPageStatus($status, $pageId);

    /**
     * Send a signed request to provider API
     *
     * @param string $url
     * @param string $method
     * @param array $parameters
     * @param array $headers
     * @param bool $multipart
     *
     * @return mixed
     */
    public function apiRequest($url, $method = 'GET', $parameters = [], $headers = [], $multipart = false);

    /**
     * Do whatever may be necessary to make sure tokens do not expire.
     * Intended to be be called frequently, e.g. via Cron.
     */
    public function maintainToken();

    /**
     * Return oauth access tokens.
     *
     * @return array
     */
    public function getAccessToken();

    /**
     * Set oauth access tokens.
     *
     * @param array $tokens
     */
    public function setAccessToken($tokens = []);

    /**
     * Set http client instance.
     *
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient = null);

    /**
     * Return http client instance.
     */
    public function getHttpClient();

    /**
     * Set storage instance.
     *
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage = null);

    /**
     * Return storage instance.
     */
    public function getStorage();

    /**
     * Set Logger instance.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger = null);

    /**
     * Return logger instance.
     */
    public function getLogger();
}
