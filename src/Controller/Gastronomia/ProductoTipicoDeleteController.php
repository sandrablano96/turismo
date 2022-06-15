<?php

namespace App\Controller\Gastronomia;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\ProductoTipico;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class ProductoTipicoDeleteController extends AbstractController
{
    #[Route('/gastronomia/producto/delete/{uid}', name: 'app_producto_tipico_delete')]
    public function delete(ManagerRegistry $doctrine, ProductoTipico $producto): Response
    {

        $gastronomiaUid = $producto->getGastronomia()->getUid();
        if ($producto == $producto->getGastronomia()->getProductoMes()) {
            $this->addFlash("aviso", "No se puede borrar un producto seleccionado como 'Producto del mes'");
            return $this->redirectToRoute('admin_gastronomia_get', [
                'uid' => $gastronomiaUid
            ]);
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($producto);
        $entityManager->flush();
        $this->addFlash("aviso", "Producto borrado correctamente");
        return $this->redirectToRoute('admin_gastronomia_get', [
            'uid' => $gastronomiaUid
        ]);
    }
}
