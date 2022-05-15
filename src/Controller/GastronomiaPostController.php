<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GastronomiaPostController extends AbstractController
{
    #[Route('/gastronomia/post', name: 'app_gastronomia_post')]
    public function index(): Response
    {
        return $this->render('gastronomia_post/index.html.twig', [
            'controller_name' => 'GastronomiaPostController',
        ]);
    }
}
