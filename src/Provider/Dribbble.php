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
 * Dribbble OAuth2 provider adapter.
 */
class Dribbble extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://api.dribbble.com/v2/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://dribbble.com/oauth/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://dribbble.com/oauth/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'http://developer.dribbble.com/v2/oauth/';

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('user');

        $data = new Data\Collection($response);

        if (!$data->exists('id')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('id');
        $userProfile->profileURL = $data->get('html_url');
        $userProfile->photoURL = $data->get('avatar_url');
        $userProfile->description = $data->get('bio');
        $userProfile->region = $data->get('location');
        $userProfile->displayName = $data->get('name');

        $userProfile->displayName = $userProfile->displayName ?: $data->get('username');

        $userProfile->websiteURL = $data->filter('links')->get('web');

        return $userProfile;
    }
}
