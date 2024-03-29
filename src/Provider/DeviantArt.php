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
 * DeviantArt OAuth2 provider adapter.
 */
class DeviantArt extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'user';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://www.deviantart.com/api/v1/oauth2/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://www.deviantart.com/oauth2/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://www.deviantart.com/oauth2/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://www.deviantart.com/developers/http/v1/20200519';

    /**
     * {@inheritdoc}
     */
    protected function initialize()
    {
        parent::initialize();

        if ($this->isRefreshTokenAvailable()) {
            $this->tokenRefreshParameters += [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ];
        }
    }

    /**
     * {@inheritdoc}
     *
     * See: https://www.deviantart.com/developers/http/v1/20200519/user_whoami/2413749853e66c5812c9beccc0ab3495
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('user/whoami');

        $data = new Data\Collection($response);

        $userProfile = new User\Profile();

        $full_name = explode(' ', $data->filter('profile')->get('real_name'));
        if (count($full_name) < 2) {
            $full_name[1] = '';
        }

        $userProfile->identifier = $data->get('userid');
        $userProfile->displayName = $data->get('username');
        $userProfile->profileURL = $data->get('usericon');
        $userProfile->websiteURL = $data->filter('profile')->get('website');
        $userProfile->firstName = $full_name[0];
        $userProfile->lastName = $full_name[1];
        $userProfile->profileURL = $data->filter('profile')->filter('profile_pic')->get('url');
        $userProfile->gender = $data->filter('details')->get('sex');
        $userProfile->age = $data->filter('details')->get('age');
        $userProfile->country = $data->filter('geo')->get('country');

        return $userProfile;
    }
}
