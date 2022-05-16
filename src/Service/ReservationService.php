<?php
namespace App\Service;

use App\Entity\Reservation;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ReservationService
{
    private $manager;

    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

    }

    public function persistReservation(Reservation $reservation, $planName, $ownerEmail): void
    {
        $reservation->setIsReserved(false)
                    ->setCreateAt(new DateTimeImmutable('now'))
                    ->setPlaName($planName)
                    ->setOwnerEmail($ownerEmail);
        $this->manager->persist($reservation);
        $this->manager->flush();

    }

    public function isReserved(Reservation $reservation): void
    {
        $reservation->setIsReserved(true);
        $this->manager->persist($reservation);
        $this->manager->flush();
    }
}