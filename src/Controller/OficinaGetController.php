<?php

namespace App\Controller;

use App\Entity\OficinaTurismo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OficinaGetController extends AbstractController
{
    #[Route('/oficina/{uid<\d+>}', name: 'app_oficina_get')]
    public function get(OficinaTurismo $oficina): Response
    {
        return $this->render('oficina_get/index.html.twig', [
            'oficina' => $oficina,
        ]);
    }
}
