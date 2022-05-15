<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioGetController extends AbstractController
{
    #[Route('/patrimonio/get', name: 'app_patrimonio_get')]
    public function index(): Response
    {
        return $this->render('patrimonio_get/index.html.twig', [
            'controller_name' => 'PatrimonioGetController',
        ]);
    }
}
