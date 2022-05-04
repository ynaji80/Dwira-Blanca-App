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
            ->setSlug("slug");
        $this->assertTrue($plan->getName()==="name");
        $this->assertTrue($plan->getTitle()==="title");
        $this->assertTrue($plan->getDescription()==="description");
        $this->assertTrue($plan->getType()==="type");
        $this->assertTrue($plan->getRating()==2.2);
        $this->assertTrue($plan->getLongitude()==20.20);
        $this->assertTrue($plan->getLatitude()==20.20);
        $this->assertTrue($plan->getCreatedAt()===$datetime);
        $this->assertTrue($plan->getSlug()==="slug");

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
            ->setSlug("slug");
        $this->assertFalse($plan->getName()==="false");
        $this->assertFalse($plan->getTitle()==="false");
        $this->assertFalse($plan->getDescription()==="false");
        $this->assertFalse($plan->gettype()==="false");
        $this->assertFalse($plan->getRating()==24.2);
        $this->assertFalse($plan->getLongitude()==24.20);
        $this->assertFalse($plan->getLatitude()==24.20);
        $this->assertFalse($plan->getCreatedAt()=== new DateTimeImmutable());
        $this->assertFalse($plan->getSlug()==="false");

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

    }
}
