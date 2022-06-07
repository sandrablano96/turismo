<?php

namespace App\Controller\Museo;

use App\Entity\Museo;
use App\Entity\PiezaMuseo;
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
class MuseoDeleteController extends AbstractController
{
    #[Route('/museo/delete/{uid}', name: 'app_museo_delete')]
    public function delete(Museo $museo, ManagerRegistry $doctrine): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($museo);
        $entityManager->flush();
        $this->addFlash("aviso", "Museo borrado correctamente");
        return $this->redirectToRoute("admin_museos_get");
    }
}
