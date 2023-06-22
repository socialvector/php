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
 * Medium OAuth2 provider adapter.
 */
class Medium extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'basicProfile';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://api.medium.com/v1/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://medium.com/m/oauth/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://api.medium.com/v1/tokens';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://github.com/Medium/medium-api-docs';

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
     * See: https://github.com/Medium/medium-api-docs#getting-the-authenticated-users-details
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('me');

        $data = new Data\Collection($response);

        $userProfile = new User\Profile();
        $data = $data->filter('data');

        $full_name = explode(' ', $data->get('name'));
        if (count($full_name) < 2) {
            $full_name[1] = '';
        }

        $userProfile->identifier = $data->get('id');
        $userProfile->displayName = $data->get('username');
        $userProfile->profileURL = $data->get('imageUrl');
        $userProfile->firstName = $full_name[0];
        $userProfile->lastName = $full_name[1];
        $userProfile->profileURL = $data->get('url');

        return $userProfile;
    }
}
