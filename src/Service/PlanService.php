<?php
namespace App\Service;

use App\Entity\Plan;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class PlanService
{
    private $manager;

    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

    }

    public function createPlan(Plan $plan): void
    {
        $plan->setIsActive(true)
            ->setCalendar(["Monday"=>"10:23","Tuesday"=>"10:23","Wednesday"=>"10:23","Thursday"=>"10:23","Friday"=>"10:23","Saturday"=>"10:23","Sunday"=>""])
            ->setSlug('slug-plan'.strval(rand()));

        $this->manager->persist($plan);
        $this->manager->flush();

    }

    
}