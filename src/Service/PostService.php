<?php
namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class PostService
{
    private $manager;

    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

    }

    public function createPost(Post $post): void
    {
        $post->setSlug('slug-post'.strval(rand()));

        $this->manager->persist($post);
        $this->manager->flush();

    }

    
}