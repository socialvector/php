<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Provider;

use SocialVector\Adapter\OpenID;

/**
 * StackExchange OpenID provider adapter.
 */
class StackExchangeOpenID extends OpenID
{
    /**
     * {@inheritdoc}
     */
    protected $openidIdentifier = 'https://openid.stackexchange.com/';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://openid.stackexchange.com/';

    /**
     * {@inheritdoc}
     */
    public function authenticateFinish()
    {
        parent::authenticateFinish();

        $userProfile = $this->storage->get($this->providerId . '.user');

        $userProfile->identifier = !empty($userProfile->identifier) ? $userProfile->identifier : $userProfile->email;
        $userProfile->emailVerified = $userProfile->email;

        // re store the user profile
        $this->storage->set($this->providerId . '.user', $userProfile);
    }
}
