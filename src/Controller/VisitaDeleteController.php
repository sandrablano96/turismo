<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaDeleteController extends AbstractController
{
    #[Route('/visita/delete', name: 'app_visita_delete')]
    public function index(): Response
    {
        return $this->render('visita_delete/index.html.twig', [
            'controller_name' => 'VisitaDeleteController',
        ]);
    }
}
