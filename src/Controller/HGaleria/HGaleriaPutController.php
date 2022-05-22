<?php

namespace App\Controller\HGaleria;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HGaleriaPutController extends AbstractController
{
    #[Route('/h/galeria/put', name: 'app_h_galeria_put')]
    public function index(): Response
    {
        return $this->render('h_galeria_put/index.html.twig', [
            'controller_name' => 'HGaleriaPutController',
        ]);
    }
}
