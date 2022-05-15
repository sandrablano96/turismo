<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaPostController extends AbstractController
{
    #[Route('/visita/post', name: 'app_visita_post')]
    public function index(): Response
    {
        return $this->render('visita_post/index.html.twig', [
            'controller_name' => 'VisitaPostController',
        ]);
    }
}
