<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GastronomiaGetController extends AbstractController
{
    #[Route('/gastronomia/get', name: 'app_gastronomia_get')]
    public function index(): Response
    {
        return $this->render('gastronomia_get/index.html.twig', [
            'controller_name' => 'GastronomiaGetController',
        ]);
    }
}
