<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoGetController extends AbstractController
{
    #[Route('/museo/get', name: 'app_museo_get')]
    public function index(): Response
    {
        return $this->render('museo_get/index.html.twig', [
            'controller_name' => 'MuseoGetController',
        ]);
    }
}
