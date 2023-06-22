<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Provider;

/**
 * WeChat China OAuth2 provider adapter.
 */
class WeChatChina extends WeChat
{
    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://api.weixin.qq.com/sns/';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    /**
     * {@inheritdoc}
     */
    protected $tokenRefreshUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';

    /**
     * {@ịnheritdoc}
     */
    protected $accessTokenInfoUrl = 'https://api.weixin.qq.com/sns/auth';
}
