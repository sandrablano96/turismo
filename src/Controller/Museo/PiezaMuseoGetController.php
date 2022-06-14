<?php

namespace App\Controller\Museo;

use App\Entity\PiezaMuseo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PiezaMuseoGetController extends AbstractController
{
    /**
     * @Route("/pieza", name="app_pieza_get",options={"expose"=true}, methods={"POST"})
     * @return Response
     */
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $uid = $parametersAsArray['itemId'];
            $pieza = $doctrine->getRepository(PiezaMuseo::class)->findOneBy(array('uid' => $uid));
            
            $response = array("code" => 200, "titulo" => $pieza->getTitulo(), "descripcion" => $pieza->getDescripcion());
            return new JsonResponse($response);
        }
    }
}
