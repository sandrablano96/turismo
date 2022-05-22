<?php

namespace App\Controller\HGaleria;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HGaleriaDeleteController extends AbstractController
{
    #[Route('/h/galeria/delete', name: 'app_h_galeria_delete')]
    public function index(): Response
    {
        return $this->render('h_galeria_delete/index.html.twig', [
            'controller_name' => 'HGaleriaDeleteController',
        ]);
    }
}
