<?php

namespace App\Controller;

use App\Entity\Patrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioDeleteController extends AbstractController
{
    #[Route('/patrimonio/delete/{uid<\d+>}', name: 'app_patrimonio_delete')]
    public function delete(Patrimonio $patrimonio, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($patrimonio);
        $entityManager->flush();
        $this->addFlash("aviso", "Patrimonio borrado correctamente");
        return $this->redirectToRoute("");
    }
}
