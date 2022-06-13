<?php

namespace App\Controller\VisitaGuiada;

use App\Entity\VisitaGuiada;
use Doctrine\Persistence\ManagerRegistry;
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
class VisitaDeleteController extends AbstractController
{
    #[Route('/visita/delete/{uid}', name: 'app_visita_delete')]
    public function delete(VisitaGuiada $visita, ManagerRegistry $doctrine, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($visita);
        $entityManager->flush();
        $this->addFlash("aviso", "Visita guiada borrada correctamente");
        return $this->redirect($request->headers->get('referer'));
    }
}
