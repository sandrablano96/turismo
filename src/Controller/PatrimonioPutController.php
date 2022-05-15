<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioPutController extends AbstractController
{
    #[Route('/patrimonio/put', name: 'app_patrimonio_put')]
    public function index(): Response
    {
        return $this->render('patrimonio_put/index.html.twig', [
            'controller_name' => 'PatrimonioPutController',
        ]);
    }
}
