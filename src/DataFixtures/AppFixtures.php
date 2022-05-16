<?php

namespace App\DataFixtures;

use App\Entity\Plan;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher= $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $user = new User();
        $user->setEmail('user@test.com')
            ->setUsername($faker->userName())
            ->setRoles(['ROLE_OWNER'])
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName());
        $password=$this->hasher->hashPassword($user,'password');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();


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
            ->setUser($user);
            $manager->persist($plan);
        }
        

        $manager->flush();
    }
}
