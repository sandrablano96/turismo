<?php

namespace App\Controller\HGaleria;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HistoriaImagenes;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class HGaleriaDeleteController extends AbstractController
{
    #[Route('/historia/galeria/delete/{uid}', name: 'app_h_galeria_delete')]
    public function index(HistoriaImagenes $imagen, ManagerRegistry $doctrine): Response
    {
      $entityManager = $doctrine->getManager();
      $historiaUid = $imagen->getHistoria()->getUid();
        $entityManager->remove($imagen);
        $entityManager->flush();
        $this->addFlash("aviso", "Imagen borrada correctamente");
        return $this->redirectToRoute('admin_historia_get', [
                'uid' => $historiaUid
        ]);
    }
}
