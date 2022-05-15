<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuiaPostController extends AbstractController
{
    #[Route('/guia/post', name: 'app_guia_post')]
    public function index(): Response
    {
        return $this->render('guia_post/index.html.twig', [
            'controller_name' => 'GuiaPostController',
        ]);
    }
}
