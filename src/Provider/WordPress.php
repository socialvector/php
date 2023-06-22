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
 * WordPress OAuth2 provider adapter.
 */
class WordPress extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://public-api.wordpress.com/rest/v1/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://public-api.wordpress.com/oauth2/authenticate';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://public-api.wordpress.com/oauth2/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://developer.wordpress.com/docs/api/';

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('me/');

        $data = new Data\Collection($response);

        if (!$data->exists('ID')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('ID');
        $userProfile->displayName = $data->get('display_name');
        $userProfile->photoURL = $data->get('avatar_URL');
        $userProfile->profileURL = $data->get('profile_URL');
        $userProfile->email = $data->get('email');
        $userProfile->language = $data->get('language');

        $userProfile->displayName = $userProfile->displayName ?: $data->get('username');

        $userProfile->emailVerified = $data->get('email_verified') ? $data->get('email') : '';

        return $userProfile;
    }
}
