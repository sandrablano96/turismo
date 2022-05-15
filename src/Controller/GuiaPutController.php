<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuiaPutController extends AbstractController
{
    #[Route('/guia/put', name: 'app_guia_put')]
    public function index(): Response
    {
        return $this->render('guia_put/index.html.twig', [
            'controller_name' => 'GuiaPutController',
        ]);
    }
}
