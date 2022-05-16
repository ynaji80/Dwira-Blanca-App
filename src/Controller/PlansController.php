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
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
        $filter=$request->query->get("filter");
        if($filter=="topRated"){
            $data = $planRepository->getTopRatedPlans();
        }
        elseif ($filter==="restaurant") {
            $data = $planRepository->getPlansByType("restaurant");

        }
        elseif ($filter=="shopping") {
            $data = $planRepository->getPlansByType("Shopping");

        }
        elseif ($filter=="museum") {
            $data = $planRepository->getPlansByType("Museum");

        }
        elseif ($filter=="park") {
            $data = $planRepository->getPlansByType("park");

        }
        else{
            $data = $planRepository->findAll();
        }
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
    public function show(Plan $plan,Request $request, ReservationService $reservationService, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
             $reservation=$form->getData();
             $reservationService->persistReservation($reservation, $plan->getName(), $plan->getUser()->getEmail());
             $email = (new Email())
                ->from('yonaji2000@gmail.com')
                ->to('hamzabessa19@gmail.com')
                ->subject('Reservation Confirmation from')
                ->text('You have booked for : ');

            $mailer->send($email);        
             return $this->redirectToRoute("app_plan_show",['slug'=>$plan->getSlug()]);
        }

        return $this->render("plans/planDetail.html.twig", [
            'reservationForm' => $form->createView(),
            "plan" => $plan,
        ]);
    }

    #[Route('/plan/create', name: 'app_plan_create', methods: 'GET|POST')]
    #[Security("is_granted('ROLE_OWNER') ")]
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
    #[Route('/plans/{slug}/edit', name: 'app_plans_edit', methods:'GET|POST')]
    #[Security("is_granted('ROLE_OWNER') && plan.getUser()==user")]
    public function edit(Plan $plan,EntityManagerInterface $em,Request $request): Response
    {
      
      
      $form= $this->createForm(PlanType::class, $plan);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
         $em->flush();
         $this->addFlash('success','Plan succefully updated !');
         return $this->redirectToRoute('app_plans');

      }

      return $this->render('plans/edit.html.twig', [
        'plan' =>$plan,
        'formEditPlan' => $form->createView()
      ]);
    }

    #[Route('/plans/{slug}', name: 'app_plans_delete', methods:'DELETE')]
    #[Security("is_granted('ROLE_OWNER') && plan.getUser()==user")]
    public function delete(Plan $plan,EntityManagerInterface $em,Request $request): Response
    {
      if($this->isCsrfTokenValid('plan_deletion'.$plan->getSlug(), $request->request->get('csrf_token'))){
        $em->remove($plan);
        $em->flush();
        $this->addFlash('info','Plan succefully deleted !');
      }
    
    return $this->redirectToRoute('app_plans');
    }
}
