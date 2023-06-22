<?php
/*!
* Social Vector
* https://socialvector.github.io | https://github.com/socialvector/php
*  (c) 2022 Social Vector authors | https://socialvector.github.io/license.html
*/

namespace SocialVector\User;

use SocialVector\Exception\UnexpectedValueException;

/**
 * Social Vector\User\Activity
 */
final class Activity
{
    /**
     * activity id on the provider side, usually given as integer
     *
     * @var string
     */
    public $id = null;

    /**
     * activity date of creation
     *
     * @var string
     */
    public $date = null;

    /**
     * activity content as a string
     *
     * @var string
     */
    public $text = null;

    /**
     * user who created the activity
     *
     * @var object
     */
    public $user = null;

    /**
     *
     */
    public function __construct()
    {
        $this->user = new \stdClass();

        // typically, we should have a few information about the user who created the event from social apis
        $this->user->identifier = null;
        $this->user->displayName = null;
        $this->user->profileURL = null;
        $this->user->photoURL = null;
    }

    /**
     * Prevent the providers adapters from adding new fields.
     *
     * @throws UnexpectedValueException
     * @var string $name
     *
     * @var mixed $value
     *
     */
    public function __set($name, $value)
    {
        // phpcs:ignore
        throw new UnexpectedValueException(sprintf('Adding new property "%s\' to %s is not allowed.', $name, __CLASS__));
    }
}
