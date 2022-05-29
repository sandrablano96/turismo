<?php

namespace App\Controller;

use \App\Entity\Patrimonio;
use App\Entity\Contacto;
use App\Entity\Evento;
use App\Entity\Gastronomia;
use App\Entity\GuiaTurismo;
use App\Entity\Historia;
use App\Entity\Museo;
use App\Entity\OficinaTurismo;
use App\Entity\VisitaGuiada;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Bridge\Doctrine\ManagerRegistry;
class MenuController extends AbstractController
{
    #[Route('/', name: 'app_main_menu')]
    public function index(): Response
    {
        return $this->render('menu/index.html.twig');
    }

    /**
     * @Route("/que_ver", name="app_see_menu")
     * @return Response
     */
    public function whatToSeeMenu(): Response
    {
        return $this->render('menu/whatToSeeMenu.html.twig');
    }
    /**
     * @Route("/admin", name="app_admin_menu")
     * @return Response
     */
    public function adminMenu(): Response
    {
        return $this->render('menu/admin/adminIndex.html.twig');
    }
    
}
