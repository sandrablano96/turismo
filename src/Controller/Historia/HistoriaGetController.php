<?php


namespace App\Controller\Historia;

use App\Entity\Historia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoriaGetController extends AbstractController
{
    #[Route('/historia/get/{uid}', name: 'app_historia_get')]
    public function getHistory(Historia $historia): Response
    {
        return $this->render('Historia/historia_get/index.html.twig', [
            'historia' => $historia
        ]);
    }
}
