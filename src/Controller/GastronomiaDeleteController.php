<?php

namespace App\Controller;

use App\Entity\ProductoTipico;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GastronomiaDeleteController extends AbstractController
{
    #[Route('/gastronomia/delete/{uid<\d+>}', name: 'app_gastronomia_delete')]
    public function delete(ProductoTipico $producto, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($producto);
        $entityManager->flush();
        $this->addFlash("aviso", "Producto borrado correctamente");
        return $this->redirectToRoute("");
    }
}
