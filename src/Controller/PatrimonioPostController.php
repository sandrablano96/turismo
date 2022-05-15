<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioPostController extends AbstractController
{
    #[Route('/patrimonio/post', name: 'app_patrimonio_post')]
    public function index(): Response
    {
        return $this->render('patrimonio_post/index.html.twig', [
            'controller_name' => 'PatrimonioPostController',
        ]);
    }
}
