<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Provider;

use SocialVector\Adapter\OpenID;

/**
 * AOL OpenID provider adapter.
 */
class AOLOpenID extends OpenID
{
    /**
     * {@inheritdoc}
     */
    protected $openidIdentifier = 'http://openid.aol.com/';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = ''; // Not available
}
