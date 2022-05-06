<?php

namespace App\DataFixtures;

use App\Entity\Plan;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        for ($i=0; $i <10 ; $i++) {
            $plan = new Plan();
            $plan->setName($faker->name())
            ->setTitle($faker->sentence())
            ->setDescription($faker->text())
            ->setType("restaurant")
            ->setRating($faker->randomFloat(1, 2, 4))
            ->setLongitude($faker->randomFloat(5, 1, 90))
            ->setLatitude($faker->randomFloat(5, 1, 90))
            ->setCreatedAt(new DateTimeImmutable())
            ->setSlug($faker->slug())
            ->setLocation($faker->address())
            ->setNumber($faker->phoneNumber())
            ->setEmail($faker->email())
            ->setWebsite($faker->domainName())
            ->setCalendar(["Monday"=>"10:23","Tuesday"=>"10:23","Wednesday"=>"10:23","Thursday"=>"10:23","Friday"=>"10:23","Saturday"=>"10:23","Sunday"=>""])
            ->setIsActive($faker->randomElement([true, false]))
            ;
        
            $manager->persist($plan);
        }
        

        $manager->flush();
    }
}
