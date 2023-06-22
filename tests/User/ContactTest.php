<?php

namespace SocialVectorTest\SocialVector\User;

use SocialVector\User\Contact;

class ContactTest extends \PHPUnit\Framework\TestCase
{
    public function test_instance_of()
    {
        $contact = new Contact();

        $this->assertInstanceOf('\\SocialVector\\User\\Contact', $contact);
    }

    public function test_has_attributes()
    {
        $contact_class = '\\SocialVector\\User\\Contact';

        $this->assertClassHasAttribute('identifier', $contact_class);
        $this->assertClassHasAttribute('websiteURL', $contact_class);
        $this->assertClassHasAttribute('profileURL', $contact_class);
        $this->assertClassHasAttribute('photoURL', $contact_class);
        $this->assertClassHasAttribute('displayName', $contact_class);
        $this->assertClassHasAttribute('description', $contact_class);
        $this->assertClassHasAttribute('email', $contact_class);
    }

    public function test_set_attributes()
    {
        $contact = new Contact();

        $contact->identifier = true;
        $contact->websiteURL = true;
        $contact->profileURL = true;
        $contact->photoURL = true;
        $contact->displayName = true;
        $contact->description = true;
        $contact->email = true;
    }

    /**
     * @expectedException \SocialVector\Exception\UnexpectedValueException
     */
    public function test_property_overloading()
    {
        $contact = new Contact();
        $contact->slug = true;
    }
}
