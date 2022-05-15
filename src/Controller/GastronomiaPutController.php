<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GastronomiaPutController extends AbstractController
{
    #[Route('/gastronomia/put', name: 'app_gastronomia_put')]
    public function index(): Response
    {
        return $this->render('gastronomia_put/index.html.twig', [
            'controller_name' => 'GastronomiaPutController',
        ]);
    }
}
