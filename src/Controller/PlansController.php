<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Repository\PlanRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\PlanType;
use App\Form\ReservationType;
use App\Service\MailerService;
use App\Service\PlanService;
use App\Service\ReservationService;
use Symfony\Component\Mailer\MailerInterface;

class PlansController extends AbstractController
{
    #[Route('/plans', name: 'app_plans')]
    public function index(
        PlanRepository $planRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // $calendar= $planRepository->getPlans()[0]->getCalendar();
        // foreach($calendar as $day => $time) {
        //     dump("{$day} : {$time}");
        // }
        $data = $planRepository->findAll();
        $plans = $paginator->paginate(
            $data,
            $request->query->getInt("page", 1),
            4
        );
        return $this->render('plans/plans.html.twig', [
            'plans' => $plans,
        ]);
    }
    #[Route('/plans/{slug}', name: 'app_plan_show', methods: ["GET|POST"])]
    public function show(Plan $plan,Request $request, ReservationService $reservationService, MailerService $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
             $reservation=$form->getData();
             $reservationService->persistReservation($reservation, $plan->getName(), $plan->getUser()->getEmail());
             $mailer->sendEmail($reservation);
             return $this->redirectToRoute("app_plan_show",['slug'=>$plan->getSlug()]);
        }

        return $this->render("plans/planDetail.html.twig", [
            'reservationForm' => $form->createView(),
            "plan" => $plan,
        ]);
    }

    #[Route('/plan/create', name: 'app_plan_create', methods: 'GET|POST')]
    public function create(Request $request, PlanService $planService ): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $plan = new Plan;
        $form= $this->createForm(PlanType::class,$plan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $plan=$form->getData();
            $plan->setUser($this->getUser());
            $planService->createPlan($plan);
            $this->addFlash('success','plan succefully created !');

            return $this->redirectToRoute('app_plans');

        }

        return $this->render('plans/create.html.twig',[
            'formPlan'=>$form->createView()]);
    }
}
