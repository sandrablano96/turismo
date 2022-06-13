<?php

namespace App\Controller\GuiaTurismo;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\GuiaTurismo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class GuiaDeleteController extends AbstractController
{
    #[Route('/guia/delete/{uid}', name: 'app_guia_delete')]
    public function delete(GuiaTurismo $guia, ManagerRegistry $doctrine, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($guia);
        $entityManager->flush();
        $this->addFlash("aviso", "Guia turística borrada correctamente");
        return $this->redirect($request->headers->get('referer'));
        
    }
}
