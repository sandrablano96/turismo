<?php

namespace App\Controller\HGaleria;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HGaleriaGetController extends AbstractController
{
    #[Route('/h/galeria/get', name: 'app_h_galeria_get')]
    public function index(): Response
    {
        return $this->render('h_galeria_get/index.html.twig', [
            'controller_name' => 'HGaleriaGetController',
        ]);
    }
}
