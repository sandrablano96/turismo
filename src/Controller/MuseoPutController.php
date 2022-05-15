<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoPutController extends AbstractController
{
    #[Route('/museo/put', name: 'app_museo_put')]
    public function index(): Response
    {
        return $this->render('museo_put/index.html.twig', [
            'controller_name' => 'MuseoPutController',
        ]);
    }
}
