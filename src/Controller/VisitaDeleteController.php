<?php

namespace App\Controller;

use App\Entity\VisitaGuiada;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaDeleteController extends AbstractController
{
    #[Route('/visita/delete/{uid<\d+>}', name: 'app_visita_delete')]
    public function index(VisitaGuiada $visita, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($visita);
        $entityManager->flush();
        $this->addFlash("aviso", "Visita guiada borrada correctamente");
        return $this->redirectToRoute("");
    }
}
