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
 * Set up your OAuth2 at https://bitbucket.org/<yourusername>/workspace/settings/api
 */

/**
 * BitBucket OAuth2 provider adapter.
 */
class BitBucket extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'email';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://api.bitbucket.org/2.0/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://bitbucket.org/site/oauth2/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://bitbucket.org/site/oauth2/access_token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://developer.atlassian.com/bitbucket/concepts/oauth2.html';

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('user');

        $data = new Data\Collection($response);

        if (!$data->exists('uuid')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('uuid');
        $userProfile->profileURL = 'https://bitbucket.org/' . $data->get('username') . '/';
        $userProfile->displayName = $data->get('display_name');
        $userProfile->email = $data->get('email');
        $userProfile->websiteURL = $data->get('website');
        $userProfile->region = $data->get('location');

        $userProfile->displayName = $userProfile->displayName ?: $data->get('username');

        if (empty($userProfile->email) && strpos($this->scope, 'email') !== false) {
            try {
                // user email is not mandatory so keep it quiet
                $userProfile = $this->requestUserEmail($userProfile);
            } catch (\Exception $e) {
            }
        }

        return $userProfile;
    }

    /**
     * Request user email
     *
     * @param $userProfile
     *
     * @return User\Profile
     *
     * @throws \Exception
     */
    protected function requestUserEmail($userProfile)
    {
        $response = $this->apiRequest('user/emails');

        foreach ($response->values as $idx => $item) {
            if (!empty($item->is_primary) && $item->is_primary == true) {
                $userProfile->email = $item->email;

                if (!empty($item->is_confirmed) && $item->is_confirmed == true) {
                    $userProfile->emailVerified = $userProfile->email;
                }

                break;
            }
        }

        return $userProfile;
    }
}
