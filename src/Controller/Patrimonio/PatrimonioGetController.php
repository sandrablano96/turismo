<?php

namespace App\Controller\Patrimonio;
use App\Entity\Patrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatrimonioGetController extends AbstractController
{
    /*
    #[Route('/patrimonio', name: 'app_patrimonio_all_get')]
    
    public function getAllHeritage(ManagerRegistry $doctrine): Response
    {
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findAll();

        return $this->render('patrimonio/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio
        ]);
    }
    */

    /**
     * @Route("/listado_patrimonio/{type}", name="app_patrimonio_tipo_get")
     * @return Response
     * 
     */
    public function getAllByType(ManagerRegistry $doctrine, Request $request, $type): Response
    {
        $typeId = $type === 'cultural' ? 2 : 1;
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findByTypeHeritage($typeId);

        return $this->render('Patrimonio/patrimonio_get/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio, 'tipo' => $type
        ]);
    }

    /**
     * @Route("/patrimonio", name="app_patrimonioOrdered_get",methods={"POST"})
     * @return Response
     * 
     */
    public function getAllHeritageOrdered(ManagerRegistry $doctrine, Request $request): Response
    {
        $order = $request->request->get('order');
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findBy(array(), array('nombre' => $order));

        return $this->render('Patrimonio/patrimonio_get/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio
        ]);
    }

    /**
     * @Route("/patrimonio/ficha/{uid}", name="app_patrimonio_get")
     * @return Response
     * 
     */
    public function getPatrimonio(Patrimonio $patrimonio): Response
    {
        return $this->render('Patrimonio/patrimonio_get/patrimonio.html.twig', [
            'patrimonio' => $patrimonio
        ]);
    }
    
    /**
     * @Route("/admin/patrimonio/{type}", name="admin_patrimonio_tipo_get")
     * @return Response
     * 
     */
    public function getAll(ManagerRegistry $doctrine, Request $request, $type): Response
    {
        $typeId = $type === 'cultural' ? 2 : 1;
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findByTypeHeritage($typeId);

        return $this->render('admin/admin_patrimonio.html.twig', [
            'patrimonio' => $arrayPatrimonio, 'tipo' => $type
        ]);
    }

    
}
