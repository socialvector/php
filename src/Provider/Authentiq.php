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
 * Authentiq OAuth2 provider adapter.
 */
class Authentiq extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'aq:name email~rs aq:push openid';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://connect.authentiq.io/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://connect.authentiq.io/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://connect.authentiq.io/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'http://developers.authentiq.io/';

    /**
     * {@inheritdoc}
     */
    protected function initialize()
    {
        parent::initialize();

        $this->AuthorizeUrlParameters += [
            'prompt' => 'consent'
        ];

        $this->tokenExchangeHeaders = [
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
        ];

        $this->tokenRefreshHeaders = [
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('userinfo');

        $data = new Data\Collection($response);

        if (!$data->exists('sub')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier = $data->get('sub');

        $userProfile->displayName = $data->get('name');
        $userProfile->firstName = $data->get('given_name');
        // $userProfile->middleName  = $data->get('middle_name'); // not supported
        $userProfile->lastName = $data->get('family_name');

        if (!empty($userProfile->displayName)) {
            $userProfile->displayName = join(' ', array($userProfile->firstName,
                // $userProfile->middleName,
                $userProfile->lastName));
        }

        $userProfile->email = $data->get('email');
        $userProfile->emailVerified = $data->get('email_verified') ? $userProfile->email : '';

        $userProfile->phone = $data->get('phone');
        // $userProfile->phoneVerified = $data->get('phone_verified') ? $userProfile->phone : ''; // not supported

        $userProfile->profileURL = $data->get('profile');
        $userProfile->websiteURL = $data->get('website');
        $userProfile->photoURL = $data->get('picture');
        $userProfile->gender = $data->get('gender');
        $userProfile->address = $data->filter('address')->get('street_address');
        $userProfile->city = $data->filter('address')->get('locality');
        $userProfile->country = $data->filter('address')->get('country');
        $userProfile->region = $data->filter('address')->get('region');
        $userProfile->postalCode = $data->filter('address')->get('postal_code');

        return $userProfile;
    }
}
