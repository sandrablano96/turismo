<?php

namespace App\Controller\Gastronomia;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\ProductoTipico;
use Doctrine\Persistence\ManagerRegistry;

class ProductoTipicoDeleteController extends AbstractController
{
    #[Route('/gastronomia/producto/delete/{uid}', name: 'app_producto_tipico_delete')]
    public function delete(ManagerRegistry $doctrine, ProductoTipico $producto): Response
    {
        $gastronomiaUid = $producto->getGastronomia()->getUid();
        $entityManager = $doctrine->getManager();
        $entityManager->remove($producto);
        $entityManager->flush();
        $this->addFlash("aviso", "Producto borrado correctamente");
        return $this->redirectToRoute('admin_gastronomia_get', [
                'uid' => $gastronomiaUid
            ]);
    }
}
