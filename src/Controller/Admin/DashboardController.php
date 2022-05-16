<?php

namespace App\Controller\Admin;

use App\Entity\Plan;
use App\Entity\Post;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

         return $this->render('admin/index.html.twig');
    }           

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dwira Blanca');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Plans', 'fa-solid fa-map-pin', Plan::class);
        yield MenuItem::linkToCrud('Posts', 'fa-solid fa-newspaper', Post::class);
        yield MenuItem::linkToCrud('Users', 'fa-solid fa-users', User::class);
    }
}
