<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Service\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    #[Route('/', name: 'app_posts',methods: 'GET')]
    public function index(PostRepository $postRepository): Response
    {
      
        $post = $postRepository->findBy([],['createdAt'=>'DESC']);
        return $this->render('posts/index.html.twig', ['posts' => $post]);
    }

    #[Route('/posts/create', name: 'app_posts_create', methods: 'GET|POST')]
    #[Security("is_granted('ROLE_USER') ")]
    public function create(Request $request, PostService $postService): Response
    {
      $this->denyAccessUnlessGranted('ROLE_USER');
      $post = new Post;
      $form= $this->createForm(PostType::class,$post);

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
          $post->setUser($this->getUser());
          $postService->createPost($post);

          $this->addFlash('success','Post succefully created !');

          return $this->redirectToRoute('app_posts');

       }

      return $this->render('posts/create.html.twig',[
        'formPosts'=>$form->createView()]);
    }

    #[Route('/posts/{slug}', name: 'app_posts_details', methods:'GET')]
    public function show(Post  $post): Response
    {
      $this->denyAccessUnlessGranted('ROLE_USER');
      return $this->render('posts/show.html.twig', compact('post'));
    }

    #[Route('/posts/{slug}/edit', name: 'app_posts_edit', methods:'GET|POST')]
    #[Security("is_granted('ROLE_USER') && post.getUser()==user")]
    public function edit(Post $post,EntityManagerInterface $em,Request $request): Response
    {
      
      
      $form= $this->createForm(PostType::class, $post);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
         $em->flush();
         $this->addFlash('success','Post succefully updated !');
         return $this->redirectToRoute('app_posts');

      }

      return $this->render('posts/edit.html.twig', [
        'post' =>$post,
        'formEditPost' => $form->createView()
      ]);
    }

    #[Route('/posts/{slug}', name: 'app_posts_delete', methods:'DELETE')]
    #[Security("is_granted('ROLE_USER') && post.getUser()==user")]
    public function delete(Post $post,EntityManagerInterface $em,Request $request): Response
    {
      if($this->isCsrfTokenValid('post_deletion'.$post->getSlug(), $request->request->get('csrf_token'))){
        $em->remove($post);
        $em->flush();
        $this->addFlash('info','Post succefully deleted !');
      }
    
    return $this->redirectToRoute('app_posts');
    }
}