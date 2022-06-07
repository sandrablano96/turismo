<?php

namespace App\Controller\Usuario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Bridge\Doctrine\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted("ROLE_USER")
 */
class UsuarioDeleteController extends AbstractController
{
    #[Route('/usuario/delete/{uid}', name: 'app_usuario_delete')]
    public function delete(Usuario $usuario, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($usuario);
        return $this->redirectToRoute("app_main_menu");
    }
}
