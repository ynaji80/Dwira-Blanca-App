<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Repository\PlanRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlansController extends AbstractController
{
    #[Route('/plans', name: 'app_plans')]
    public function index(PlanRepository $planRepository, PaginatorInterface $paginator, Request $request): Response

    {
        // $calendar= $planRepository->getPlans()[0]->getCalendar();
        // foreach($calendar as $day => $time) {
        //     dump("{$day} : {$time}");
        // }
        $data= $planRepository->findAll();
        $plans=$paginator->paginate(
            $data,
            $request->query->getInt("page", 1),
            4
        );
        return $this->render('plans/plans.html.twig', [
            'plans' => $plans,
        ]);
    }
    #[Route('/plans/{id<[0-9]+>}', name: 'app_plan_show', methods:["GET"])]
    public function show(Plan $plan): Response
    {
        return $this->render("plans/planDetail.html.twig", ["plan" => $plan]);
    }
}
