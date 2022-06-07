<?php

namespace App\Controller\Patrimonio;

use App\Entity\Patrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class PatrimonioDeleteController extends AbstractController
{
    #[Route('/patrimonio/{type}/delete/{uid}', name: 'app_patrimonio_delete')]
    public function delete(Patrimonio $patrimonio, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($patrimonio);
        $entityManager->flush();
        $this->addFlash("aviso", "Patrimonio borrado correctamente");
        return $this->redirectToRoute("admin_patrimonio_tipo_get", ['type' => $type]);;
    }
}
