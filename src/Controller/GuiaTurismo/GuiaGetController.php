<?php


namespace App\Controller\GuiaTurismo;

use App\Entity\GuiaTurismo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuiaGetController extends AbstractController
{
    #[Route("/guias", name: 'app_guias_get')]
    public function getAllGuides(ManagerRegistry $doctrine): Response
    {
        $guias = $doctrine->getRepository(GuiaTurismo::class)->findAll();
        
        return $this->render('Guia/guia_get/index.html.twig', [
            'guias' => $guias
        ]);
    }

   /**
     * @Route("/guia/{uid}", name="app_guia_get")
     * @return Response
     */
    public function getGuide(GuiaTurismo $guide): Response
    {
        return $this->render('Guia/guia_get/guia.html.twig', [
            'guia' => $guide
        ]);
    }
    
    /**
     * @Route("/admin/guias", name="admin_guias_get")
     * @return Response
     */
    
    public function getAll(ManagerRegistry $doctrine): Response
    {
        $guias = $doctrine->getRepository(GuiaTurismo::class)->findAll();
        
        return $this->render('admin/admin_guias.html.twig', [
            'guias' => $guias
        ]);
    }
    
    /**
     * @Route("admin/guia/{uid}/visitas", name="app_guia_visitas_get")
     * @return Response
     */
    public function getGuideVisits(GuiaTurismo $guide): Response
    {
        return $this->render('admin/admin_guia_visitas.html.twig', [
            'guia' => $guide
        ]);
    }
}
