<?php

namespace App\Controller;

use App\Entity\Gastronomia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

class GastronomiaPutController extends AbstractController
{
    #[Route('/gastronomia/put/{uid<\d+>}', name: 'app_gastronomia_put')]
    public function put(Gastronomia $gastronomia, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('gastronomia_put/index.html.twig', [
            'controller_name' => 'GastronomiaPutController',
        ]);
    }
}
