<?php

namespace App\Controller;

use App\Entity\Patrimonio;
use App\Entity\TipoPatrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioGetController extends AbstractController
{
    #[Route('/patrimonio', name: 'app_patrimonio_all_get')]
    
    public function getAllHeritage(ManagerRegistry $doctrine, $tipo): Response
    {
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findAll();

        return $this->render('patrimonio/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio
        ]);
    }
    /**
     * @Route("/patrimonio", name="app_patrimonio_tipo_get", methods={"POST"})
     * @return Response
     * 
     */
    public function getAllFiltered(ManagerRegistry $doctrine, Request $request, $tipo, $nombre): Response
    {
        $order = $request->request->get('order');
        $tipo = $request->request->get('tipo');
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findByTypeHeritage($tipo);

        return $this->render('patrimonio/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio
        ]);
    }

    /**
     * @Route("/patrimonio", name="app_patrimonio_all_get",methods={"POST"})
     * @return Response
     * 
     */
    public function getAllHeritageOrdered(ManagerRegistry $doctrine, Request $request): Response
    {
        $order = $request->request->get('order');
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findBy(array(), array('nombre' => $order));

        return $this->render('patrimonio/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio
        ]);
    }

    /**
     * @Route("/patrimonio/{uid<\d+>}", name="app_patrimonio_get")
     * @return Response
     * 
     */
    public function getPatrimonio(Patrimonio $patrimonio): Response
    {
        return $this->render('patrimonio_get/museo.html.twig', [
            'patrimonio' => $patrimonio
        ]);
    }
}
