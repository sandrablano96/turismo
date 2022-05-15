<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuiaDeleteController extends AbstractController
{
    #[Route('/guia/delete', name: 'app_guia_delete')]
    public function index(): Response
    {
        return $this->render('guia_delete/index.html.twig', [
            'controller_name' => 'GuiaDeleteController',
        ]);
    }
}
