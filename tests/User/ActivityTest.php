<?php

namespace SocialVectorTest\SocialVector\User;

use SocialVector\User\Activity;

class ActivityTest extends \PHPUnit\Framework\TestCase
{
    public function test_instance_of()
    {
        $activity = new Activity();

        $this->assertInstanceOf('\\SocialVector\\User\\Activity', $activity);
    }

    public function test_has_attributes()
    {
        $activity_class = '\\SocialVector\\User\\Activity';

        $this->assertClassHasAttribute('id', $activity_class);
        $this->assertClassHasAttribute('date', $activity_class);
        $this->assertClassHasAttribute('text', $activity_class);
        $this->assertClassHasAttribute('user', $activity_class);
    }

    public function test_set_attributes()
    {
        $activity = new Activity();

        $activity->id = true;
        $activity->date = true;
        $activity->text = true;
        $activity->user = true;
    }

    /**
     * @expectedException \SocialVector\Exception\UnexpectedValueException
     */
    public function test_property_overloading()
    {
        $activity = new Activity();
        $activity->slug = true;
    }
}
