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
 * Discord OAuth2 provider adapter.
 */
class Discord extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'identify email';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://discordapp.com/api/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://discordapp.com/api/oauth2/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://discordapp.com/api/oauth2/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://discordapp.com/developers/docs/topics/oauth2';

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
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('users/@me');

        $data = new Data\Collection($response);

        if (!$data->exists('id')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        // Makes display name more unique.
        $displayName = $data->get('username') ?: $data->get('login');
        if ($discriminator = $data->get('discriminator')) {
            $displayName .= "#{$discriminator}";
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('id');
        $userProfile->displayName = $displayName;
        $userProfile->email = $data->get('email');

        if ($data->get('verified')) {
            $userProfile->emailVerified = $data->get('email');
        }

        if ($data->get('avatar')) {
            $userProfile->photoURL = 'https://cdn.discordapp.com/avatars/';
            $userProfile->photoURL .= $data->get('id') . '/' . $data->get('avatar') . '.png';
        }

        return $userProfile;
    }
}
