<?php

namespace App\Controller\Eventos;

use App\Entity\Evento;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventoDeleteController extends AbstractController
{
    #[Route('/evento/delete/{uid}', name: 'app_evento_delete')]
    public function delete(ManagerRegistry $doctrine, Evento $evento): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($evento);
        $entityManager->flush();
        $this->addFlash("aviso", "Evento borrado correctamente");
        return $this->redirectToRoute("");
    }
}
