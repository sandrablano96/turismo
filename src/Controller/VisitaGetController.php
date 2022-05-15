<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaGetController extends AbstractController
{
    #[Route('/visita/get', name: 'app_visita_get')]
    public function index(): Response
    {
        return $this->render('visita_get/index.html.twig', [
            'controller_name' => 'VisitaGetController',
        ]);
    }
}
