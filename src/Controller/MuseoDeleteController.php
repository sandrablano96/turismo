<?php

namespace App\Controller;

use App\Entity\Museo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoDeleteController extends AbstractController
{
    #[Route('/museo/delete/{uid<\d+>}', name: 'app_museo_delete')]
    public function delete(Museo $museo, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($museo);
        $entityManager->flush();
        $this->addFlash("aviso", "Museo borrado correctamente");
        return $this->redirectToRoute("");
    }
}
