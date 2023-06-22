<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\Logger;

use Psr\Log\LoggerAwareTrait;

/**
 * Wrapper for PSR3 logger.
 */
class Psr3LoggerWrapper implements LoggerInterface
{
    use LoggerAwareTrait;

    /**
     * @inheritdoc
     */
    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context);
    }

    /**
     * @inheritdoc
     */
    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $context);
    }

    /**
     * @inheritdoc
     */
    public function error($message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }
}
