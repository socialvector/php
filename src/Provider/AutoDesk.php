<?php
/**
 * Social Vector
 * https://socialvector.github.io | https://github.com/socialvector/php
 *  (c) 2020 Social Vector authors | https://socialvector.github.io/license.html
 */

namespace SocialVector\Provider;

use SocialVector\Adapter\OAuth2;
use SocialVector\Exception\UnexpectedApiResponseException;
use SocialVector\Data;
use SocialVector\User;

/**
 * AutoDesk OAuth2 provider adapter.
 */
class AutoDesk extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'data:read';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://developer.api.autodesk.com/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl
        = 'https://developer.api.autodesk.com/authentication/v1/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl
        = 'https://developer.api.autodesk.com/authentication/v1/gettoken';

    /**
     * {@inheritdoc}
     */
    protected $refreshTokenUrl
        = 'https://developer.api.autodesk.com/authentication/v1/refreshtoken';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation
        = 'https://forge.autodesk.com/en/docs/oauth/v2/developers_guide/overview/';

    /**
     * {@inheritdoc}
     */
    protected function initialize()
    {
        parent::initialize();

        if ($this->isRefreshTokenAvailable()) {
            $this->tokenRefreshParameters += [
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type'    => 'refresh_token',
            ];
        }
    }

    /**
     * {@inheritdoc}
     *
     * See: https://forge.autodesk.com/en/docs/oauth/v2/reference/http/users-@me-GET/
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('userprofile/v1/users/@me');

        $collection = new Data\Collection($response);

        $userProfile = new User\Profile();

        $userProfile->identifier = $collection->get('userId');
        $userProfile->displayName
            = $collection->get('firstName') .' '. $collection->get('lastName');
        $userProfile->firstName = $collection->get('firstName');
        $userProfile->lastName = $collection->get('lastName');
        $userProfile->email = $collection->get('emailId');
        $userProfile->language = $collection->get('language');
        $userProfile->websiteURL = $collection->get('websiteURL');
        $userProfile->photoURL
            = $collection->filter('profileImages')->get('sizeX360');

        return $userProfile;
    }
}
