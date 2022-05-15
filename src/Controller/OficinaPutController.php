<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OficinaPutController extends AbstractController
{
    #[Route('/oficina/put', name: 'app_oficina_put')]
    public function index(): Response
    {
        return $this->render('oficina_put/index.html.twig', [
            'controller_name' => 'OficinaPutController',
        ]);
    }
}
