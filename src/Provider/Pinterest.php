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
 * Pinterest OAuth2 provider adapter.
 */
class Pinterest extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'read_public';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://api.pinterest.com/v1/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://api.pinterest.com/oauth';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://api.pinterest.com/v1/oauth/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://developers.pinterest.com/docs/api/overview/';

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('me');

        $data = new Data\Collection($response);

        $data = $data->filter('data');

        if (!$data->exists('id')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('id');
        $userProfile->description = $data->get('bio');
        $userProfile->photoURL = $data->get('image');
        $userProfile->displayName = $data->get('username');
        $userProfile->firstName = $data->get('first_name');
        $userProfile->lastName = $data->get('last_name');
        $userProfile->profileURL = "https://pinterest.com/{$data->get('username')}";

        $userProfile->data = (array)$data->get('counts');

        return $userProfile;
    }
}
