<?php

namespace App\Controller\Usuario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Usuario;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 *
 * @IsGranted("ROLE_USER")
 */
class UsuarioGetController extends AbstractController
{
    #[Route('/mi_perfil/{uid}', name: 'app_usuario_get')]
    public function get(Usuario $usuario): Response
    {
        return $this->render('Usuario/usuario_get/index.html.twig', [
            'usuario' => $usuario,
        ]);
    }
}
