<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OficinaGetController extends AbstractController
{
    #[Route('/oficina/get', name: 'app_oficina_get')]
    public function index(): Response
    {
        return $this->render('oficina_get/index.html.twig', [
            'controller_name' => 'OficinaGetController',
        ]);
    }
}
