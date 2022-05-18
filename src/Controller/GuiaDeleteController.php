<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\GuiaTurismo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuiaDeleteController extends AbstractController
{
    #[Route('/guia/delete/{uid<\d+>}', name: 'app_guia_delete')]
    public function delete(GuiaTurismo $guia, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($guia);
        $entityManager->flush();
        $this->addFlash("aviso", "Guia turística borrada correctamente");
        return $this->redirectToRoute("");
        
    }
}
