<?php

namespace App\Controller\HGaleria;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HGaleriaPostController extends AbstractController
{
    #[Route('/h/galeria/post', name: 'app_h_galeria_post')]
    public function index(): Response
    {
        return $this->render('h_galeria_post/index.html.twig', [
            'controller_name' => 'HGaleriaPostController',
        ]);
    }
}
