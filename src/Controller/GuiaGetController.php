<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuiaGetController extends AbstractController
{
    #[Route('/guia/get', name: 'app_guia_get')]
    public function index(): Response
    {
        return $this->render('guia_get/index.html.twig', [
            'controller_name' => 'GuiaGetController',
        ]);
    }
}
