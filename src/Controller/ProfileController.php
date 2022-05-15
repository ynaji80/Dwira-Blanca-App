<?php

namespace App\Controller;

use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function show(): Response
    {
        if(! $this->getUser()){
            $this->addFlash('error','you need to login first');
             return  $this->redirectToRoute('app_login');
        }

        return $this->render('profile/show.html.twig');
    }

    #[Route('/profile/edit', name: 'app_profile_edit', methods:'GET|POST')]
    public function edit(Request $request,EntityManagerInterface $em): Response
    {
        $user= $this->getUser();
        $form= $this->createForm(UserFormType::class, $user);
        $form -> handleRequest($request);
        
    
        if($form->isSubmitted() && $form->isValid()){
            
              $em->flush();
              $this->addFlash('success','Post succefully updated !');
  
            return $this->redirectToRoute('app_profile');
  
        }

        return $this->render('profile/edit.html.twig', ['form' => $form->createView()]);
    }
}
