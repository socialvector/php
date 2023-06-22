<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Provider;

use SocialVector\Adapter\OAuth2;
use SocialVector\Exception\UnexpectedApiResponseException;
use SocialVector\Data;
use SocialVector\User;

/**
 * Seznam OAuth2 provider adapter.
 */
class Seznam extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://login.szn.cz/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://login.szn.cz/api/v1/oauth/auth';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://login.szn.cz/api/v1/oauth/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://vyvojari.seznam.cz/oauth/doc';

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('api/v1/user', 'GET', ['format' => 'json']);

        $data = new Data\Collection($response);

        if (!$data->exists('oauth_user_id')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('oauth_user_id');
        $userProfile->email = $data->get('account_name');
        $userProfile->firstName = $data->get('firstname');
        $userProfile->lastName = $data->get('lastname');
        $userProfile->photoURL = $data->get('avatar_url');

        return $userProfile;
    }
}
