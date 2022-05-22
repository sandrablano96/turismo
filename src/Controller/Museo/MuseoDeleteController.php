<?php

namespace App\Controller\Museo;

use App\Entity\Museo;
use App\Entity\PiezaMuseo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoDeleteController extends AbstractController
{
    #[Route('/museo/delete/{uid}', name: 'app_museo_delete')]
    public function delete(Museo $museo, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($museo);
        $entityManager->flush();
        $this->addFlash("aviso", "Museo borrado correctamente");
        return $this->redirectToRoute("");
    }
    /**
     * @Route("/pieza/delete/{uid}", name="app_pieza_delete", methods={"POST"})
     * @return Response
     */
    public function deleteMuseumPiece(PiezaMuseo $pieza, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($pieza);
        $entityManager->flush();
        $this->addFlash("aviso", "Pieza del museo borrada correctamente");
        return $this->redirectToRoute("");
    }
}
