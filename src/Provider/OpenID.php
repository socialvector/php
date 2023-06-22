<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Provider;

use SocialVector\Adapter;

/**
 * Generic OpenID providers adapter.
 *
 * Example:
 *
 *   $config = [
 *       'callback' => SocialVector\HttpClient\Util::getCurrentUrl(),
 *
 *       //  authenticate with Yahoo openid
 *       'openid_identifier' => 'https://open.login.yahooapis.com/openid20/www.yahoo.com/xrds'
 *
 *       //  authenticate with stackexchange network openid
 *       // 'openid_identifier' => 'https://openid.stackexchange.com/',
 *
 *       //  authenticate with Steam openid
 *       // 'openid_identifier' => 'http://steamcommunity.com/openid',
 *
 *       // etc.
 *   ];
 *
 *   $adapter = new SocialVector\Provider\OpenID($config);
 *
 *   try {
 *       $adapter->authenticate();
 *
 *       $userProfile = $adapter->getUserProfile();
 *   } catch (\Exception $e) {
 *       echo $e->getMessage() ;
 *   }
 */
class OpenID extends Adapter\OpenID
{
}
