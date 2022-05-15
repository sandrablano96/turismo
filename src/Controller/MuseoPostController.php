<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoPostController extends AbstractController
{
    #[Route('/museo/post', name: 'app_museo_post')]
    public function index(): Response
    {
        return $this->render('museo_post/index.html.twig', [
            'controller_name' => 'MuseoPostController',
        ]);
    }
}
