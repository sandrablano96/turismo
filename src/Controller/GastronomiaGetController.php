<?php

namespace App\Controller;

use App\Entity\Gastronomia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GastronomiaGetController extends AbstractController
{
    #[Route('/gastronomia/{uid<\d+>}', name: 'app_gastronomia_get')]
    public function get(Gastronomia $gastronomy): Response
    {
        return $this->render('gastronomia_get/index.html.twig', [
            'productos' => $gastronomy->getProductosTipicos(), 'gastronomia' => $gastronomy->getDescripcion()
        ]);
    }
}
