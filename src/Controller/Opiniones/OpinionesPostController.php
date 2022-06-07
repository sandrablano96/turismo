<?php

namespace App\Controller\Opiniones;

use App\Entity\OpinionesVisitasGuiadas;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\VisitaGuiada;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * 
 *
 * @IsGranted("ROLE_USER")
 */
class OpinionesPostController extends AbstractController {

    /**
     * @Route("/{uid}/comentar", name="app_opiniones_post", options={"expose"=true}, methods={"POST"})
     * @return Response
     * 
     */
    public function post(ManagerRegistry $doctrine, Request $request, VisitaGuiada $visita): Response {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $opinion = $parametersAsArray['opinion'];

            $opinionesDB = $doctrine->getManager()->getRepository(OpinionesVisitasGuiadas::class)->findOneByUserAndVisit($visita->getId(), $this->getUser()->getId());

            if (count($opinionesDB) == 0) {
                $opinionVisita = new OpinionesVisitasGuiadas();
                $opinionVisita->setOpinion($opinion);
                $opinionVisita->setVisitaGuiada($visita);
                $opinionVisita->setUsuario($this->getUser());
                $uuid = Uuid::uuid4();
                $opinionVisita->setUid($uuid->toString());
                $entityManager = $doctrine->getManager();

                $entityManager->persist($opinionVisita);
                $entityManager->flush();
                $response = array("code" => 200, "data" => array(
                    "usuario" => $this->getUser()->getNombre(), "opinion" => $opinion, 
                    "uid" => $opinionVisita->getUid()));
            }
            else{
                $response = array("code" => 500, 'error' => 'ya existe');
            }



            return new JsonResponse($response);
        }
    }

}
