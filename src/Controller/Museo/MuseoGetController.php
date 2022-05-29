<?php
namespace App\Controller\Museo;
use App\Entity\Museo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseoGetController extends AbstractController
{
    #[Route('/museos', name: 'app_museos_get')]
    public function getAllMuseos(ManagerRegistry $doctrine): Response
    {
        $arrayMuseos = $doctrine->getRepository(Museo::class)->findAll();
        return $this->render('Museo/museo_get/index.html.twig', [
            'museos' => $arrayMuseos
        ]);
    }

    /**
     * @Route("/museos", name="app_museosOrdered_get", methods={"POST"})
     * @return Response
     */
    public function getAllMuseosOrdered(ManagerRegistry $doctrine, Request $request): Response
    {
        $order = $request->request->get('order');
        $museos = $doctrine->getRepository(Museo::class)->findBy(array(), array('nombre' => $order));
        return $this->render('Museo/museo_get/index.html.twig', [
            'museos' => $museos
        ]);
    }
    
    /**
     * @Route("/museo/{uid}", name="app_museo_get")
     * @return Response
     */
    public function getMuseo(Museo $museo): Response
    {
        return $this->render('Museo/museo_get/museo.html.twig', [
            'museo' => $museo
        ]);
    }
    /**
     * @Route("admin/museo/{uid}", name="admin_museo_get")
     * @return Response
     */
    public function getMuseoData(Museo $museo): Response
    {
        return $this->render('admin/admin_museo.html.twig', [
            'museo' => $museo
        ]);
    }
    
    /**
     * @Route("admin/museos", name="admin_museos_get")
     */
    public function getAll(ManagerRegistry $doctrine): Response
    {
        $arrayMuseos = $doctrine->getRepository(Museo::class)->findAll();
        return $this->render('admin/admin_museos.html.twig', [
            'museos' => $arrayMuseos
        ]);
    }

}
