<?php

namespace App\Controller\Gastronomia;

use App\Entity\Gastronomia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GastronomiaGetController extends AbstractController
{
    #[Route('/gastronomia/{uid}', name: 'app_gastronomia_get')]
    public function getGastronomy(Gastronomia $gastronomy): Response
    {
        return $this->render('Gastronomia/gastronomia_get/index.html.twig', [
            'gastronomia' => $gastronomy,
        ]);
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/gastronomía/{uid}", name="admin_gastronomia_get")
     */
    public function get(Gastronomia $gastronomy): Response
    {
        return $this->render('admin/admin_gastronomia.html.twig', [
            'gastronomia' => $gastronomy,
        ]);
    }
}
