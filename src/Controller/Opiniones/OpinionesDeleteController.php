<?php

namespace App\Controller\Opiniones;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OpinionesVisitasGuiadas;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use \Symfony\Component\HttpFoundation\JsonResponse;
/**
 * 
 *
 * @IsGranted("ROLE_USER")
 */
class OpinionesDeleteController extends AbstractController
{
    /**
     * @Route("/opiniones/delete/{uid}", name="app_opiniones_delete", options={"expose"=true}, methods={"DELETE"})
     * @return Response
     * 
     */
    public function delete(OpinionesVisitasGuiadas $opinion, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($opinion);
        $entityManager->flush();
        $response = array('code' => 200);
        return new JsonResponse($response);
    }
}
