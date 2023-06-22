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
 * Blizzard US/SEA Battle.net OAuth2 provider adapter.
 */
class BlizzardAPAC extends Blizzard
{
    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://apac.battle.net/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://apac.battle.net/oauth/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://apac.battle.net/oauth/token';
}
