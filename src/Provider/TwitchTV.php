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
 * TwitchTV OAuth2 provider adapter.
 */
class TwitchTV extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'user:read:email';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://api.twitch.tv/helix/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://id.twitch.tv/oauth2/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://id.twitch.tv/oauth2/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://dev.twitch.tv/docs/authentication/';

    /**
     * {@inheritdoc}
     */
    protected function initialize()
    {
        parent::initialize();

        $this->apiRequestHeaders['Client-ID'] = $this->clientId;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('users');

        $data = new Data\Collection($response);

        if (!$data->exists('data')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $users = $data->filter('data')->values();
        $user = new Data\Collection($users[0]);

        $userProfile = new User\Profile();

        $userProfile->identifier = $user->get('id');
        $userProfile->displayName = $user->get('display_name');
        $userProfile->photoURL = $user->get('profile_image_url');
        $userProfile->email = $user->get('email');
        $userProfile->description = strip_tags($user->get('description'));
        $userProfile->profileURL = "https://www.twitch.tv/{$userProfile->displayName}";

        return $userProfile;
    }
}
