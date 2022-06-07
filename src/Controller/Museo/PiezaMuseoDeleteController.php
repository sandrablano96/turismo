<?php

namespace App\Controller\Museo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class PiezaMuseoDeleteController extends AbstractController
{
    #[Route('/museo/piezas/delete/{uid}', name: 'app_pieza_museo_delete')]
    public function delete(PiezaMuseo $pieza, ManagerRegistry $doctrine): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $museoUid = $pieza->getMuseo()->getUid();
        $entityManager = $doctrine->getManager();
        $entityManager->remove($pieza);
        $entityManager->flush();
        $this->addFlash("aviso", "Pieza del museo borrada correctamente");
        return $this->redirectToRoute("admin_museo_get");
    
    }
}
