<?php

use App\Model\Charity;
use PHPUnit\Framework\TestCase;

class CharityTest extends TestCase
{
    public function testSetNameWithValidName()
    {
        $charity = new Charity(1, "Charity Name", "email@example.com");
        $charity->setName("New Charity Name");

        $this->assertEquals("New Charity Name", $charity->getName());
    }

    public function testSetNameWithEmptyName()
    {
        $this->expectException(InvalidArgumentException::class);
        $charity = new Charity(1, "Charity Name", "email@example.com");
        $charity->setName("");
    }

    public function testSetEmailWithValidEmail()
    {
        $charity = new Charity(1, "Charity Name", "email@example.com");
        $charity->setEmail("new.email@example.com");

        $this->assertEquals("new.email@example.com", $charity->getEmail());
    }

    public function testSetEmailWithInvalidEmail()
    {
        $this->expectException(InvalidArgumentException::class);
        $charity = new Charity(1, "Charity Name", "email@example.com");
        $charity->setEmail("invalid-email");
    }
}
