<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaPutController extends AbstractController
{
    #[Route('/visita/put', name: 'app_visita_put')]
    public function index(): Response
    {
        return $this->render('visita_put/index.html.twig', [
            'controller_name' => 'VisitaPutController',
        ]);
    }
}
