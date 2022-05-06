<?php

namespace App\Tests;

use App\Entity\Plan;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PlanUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $plan = new Plan();
        $datetime = new DateTimeImmutable();

        $plan->setName("name")
            ->setTitle("title")
            ->setDescription("description")
            ->setType("type")
            ->setRating(2.2)
            ->setLongitude(20.20)
            ->setLatitude(20.20)
            ->setCreatedAt($datetime)
            ->setSlug("slug")
            ->setLocation("location")
            ->setNumber("number")
            ->setEmail("email")
            ->setWebsite("website")
            ->setIsActive(true);
        $this->assertTrue($plan->getName()==="name");
        $this->assertTrue($plan->getTitle()==="title");
        $this->assertTrue($plan->getDescription()==="description");
        $this->assertTrue($plan->getType()==="type");
        $this->assertTrue($plan->getRating()==2.2);
        $this->assertTrue($plan->getLongitude()==20.20);
        $this->assertTrue($plan->getLatitude()==20.20);
        $this->assertTrue($plan->getCreatedAt()===$datetime);
        $this->assertTrue($plan->getSlug()==="slug");
        $this->assertTrue($plan->getLocation()==="location");
        $this->assertTrue($plan->getNumber()==="number");
        $this->assertTrue($plan->getEmail()==="email");
        $this->assertTrue($plan->getWebsite()==="website");
        $this->assertTrue($plan->getIsActive()===true);
    }
    
    public function testIsFalse()
    {
        $plan = new Plan();
        $datetime = new DateTimeImmutable();

        $plan->setName("name")
            ->setTitle("title")
            ->setDescription("description")
            ->setType("type")
            ->setRating(2.2)
            ->setLongitude(20.20)
            ->setLatitude(20.20)
            ->setCreatedAt($datetime)
            ->setSlug("slug")
            ->setLocation("location")
            ->setNumber("number")
            ->setEmail("email")
            ->setWebsite("website")
            ->setIsActive(true);
        $this->assertFalse($plan->getName()==="false");
        $this->assertFalse($plan->getTitle()==="false");
        $this->assertFalse($plan->getDescription()==="false");
        $this->assertFalse($plan->gettype()==="false");
        $this->assertFalse($plan->getRating()==24.2);
        $this->assertFalse($plan->getLongitude()==24.20);
        $this->assertFalse($plan->getLatitude()==24.20);
        $this->assertFalse($plan->getCreatedAt()=== new DateTimeImmutable());
        $this->assertFalse($plan->getSlug()==="false");
        $this->assertFalse($plan->getLocation()==="false");
        $this->assertFalse($plan->getNumber()==="false");
        $this->assertFalse($plan->getEmail()==="false");
        $this->assertFalse($plan->getWebsite()==="false");
        $this->assertFalse($plan->getIsActive()===false);
    }

    public function testIsEmpty()
    {
        $plan = new Plan();
    
        $this->assertEmpty($plan->getName());
        $this->assertEmpty($plan->getTitle());
        $this->assertEmpty($plan->getDescription());
        $this->assertEmpty($plan->gettype());
        $this->assertEmpty($plan->getRating());
        $this->assertEmpty($plan->getLongitude());
        $this->assertEmpty($plan->getLatitude());
        $this->assertEmpty($plan->getCreatedAt());
        $this->assertEmpty($plan->getSlug());
        $this->assertEmpty($plan->getNumber());
        $this->assertEmpty($plan->getEmail());
        $this->assertEmpty($plan->getWebsite());
        $this->assertEmpty($plan->getLocation());
        $this->assertEmpty($plan->getIsActive());
    }
}
