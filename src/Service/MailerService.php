<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Entity\User;    
use App\Service\ReservationService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Security;

class MailerService
{

    private $reservationRepository;
    private $mailer;
    private $reservationService;
    
    public function __construct(
         MailerInterface $mailer,
         ReservationService $reservationService,
         ReservationRepository $reservationRepository
         )
    {
        $this->reservationRepository = $reservationRepository;
        $this->mailer = $mailer;
        $this->reservationService = $reservationService;
    }
    public function sendEmail(Reservation $reservation): void
    {
        $email = (new TemplatedEmail())
                ->from("yonaji2000@gmail.com")
                ->to("hamzabessa19@gmail.com")
                ->subject('Reservation Confirmation from')
                ->text('You have booked for : ');

        $this->mailer->send($email);
        $this->reservationService->isReserved($reservation);
    
    }
}