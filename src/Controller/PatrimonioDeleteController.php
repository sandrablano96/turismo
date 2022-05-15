<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioDeleteController extends AbstractController
{
    #[Route('/patrimonio/delete', name: 'app_patrimonio_delete')]
    public function index(): Response
    {
        return $this->render('patrimonio_delete/index.html.twig', [
            'controller_name' => 'PatrimonioDeleteController',
        ]);
    }
}
