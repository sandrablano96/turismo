<?php


namespace App\Controller\VisitaGuiada;

use App\Entity\VisitaGuiada;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaGetController extends AbstractController
{
    #[Route('/visitas', name: 'app_visitas_get')]
    public function getAllVisits(ManagerRegistry $doctrine)
    {
        $arrayVisitas = $doctrine->getRepository(VisitaGuiada::class)->findAll();
        return $this->render('Visita/visita_get/index.html.twig', [
            'visitas' => $arrayVisitas
        ]);
    }

    /**
     * @Route("/visitas", name="app_visitasOrdered_get", methods={"POST"})
     * @return Response
     */
    public function getAllVisitsOrdered(ManagerRegistry $doctrine, Request $request): Response
    {
        $order = $request->request->get('order');
        $visits = $doctrine->getRepository(VisitaGuiada::class)->findBy(array(), array('fecha' => $order));
        return $this->render('Visita/visita_get/index.html.twig', [
            'visitas' => $visits
        ]);
    }
    
    /**
     * @Route("/admin/visitas", name="admin_visitas_get")
     * @return Response
     */
    public function getAll(ManagerRegistry $doctrine)
    {
        $arrayVisitas = $doctrine->getRepository(VisitaGuiada::class)->findAll();
        return $this->render('admin/admin_visitas.html.twig', [
            'visitas' => $arrayVisitas
        ]);
    }
}
