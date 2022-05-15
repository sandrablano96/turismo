<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GastronomiaDeleteController extends AbstractController
{
    #[Route('/gastronomia/delete', name: 'app_gastronomia_delete')]
    public function index(): Response
    {
        return $this->render('gastronomia_delete/index.html.twig', [
            'controller_name' => 'GastronomiaDeleteController',
        ]);
    }
}
