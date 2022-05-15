<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoDeleteController extends AbstractController
{
    #[Route('/museo/delete', name: 'app_museo_delete')]
    public function index(): Response
    {
        return $this->render('museo_delete/index.html.twig', [
            'controller_name' => 'MuseoDeleteController',
        ]);
    }
}
