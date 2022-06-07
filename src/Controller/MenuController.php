<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminMenu(): Response
    {
        return $this->render('menu/admin/adminIndex.html.twig');
    }
    
}
