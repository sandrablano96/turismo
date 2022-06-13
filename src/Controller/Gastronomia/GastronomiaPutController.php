<?php

namespace App\Controller\Gastronomia;

use App\Entity\Gastronomia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \App\Entity\ProductoTipico;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class GastronomiaPutController extends AbstractController
{
    #[Route('/gastronomia/put/{uid}', name: 'app_gastronomia_put')]
    public function put(Gastronomia $gastronomia, Request $request, ManagerRegistry $doctrine): Response
    {
        $productos = $doctrine->getRepository(ProductoTipico::class)->findAll();
        $form = $this->createFormBuilder($gastronomia)
                ->add('descripcion', TextareaType::class, [
                    'label' => 'Descripción*',
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'La descripción no puede quedar vacía',
                    ])
                    ]
                ])
                ->add('productoMes', EntityType::class, [
                    'label' => 'Producto del mes',
                    'class' => ProductoTipico::class,
                    'choices' => $productos, 
                    'choice_label' => 'nombre', 
                    'choice_value' => 'uid', 
                    'required' => false
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gastronomia = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($gastronomia);
            $entityManager->flush();
 
            $this->addFlash("aviso","Gastronomia actualizada correctamente");
            return $this->redirectToRoute('admin_gastronomia_get', [
                'uid' => $gastronomia->getUid()
            ]);
        }else{
            return $this->renderForm("Gastronomia/gastronomia_put/index.html.twig", ['formulario' => $form]);
        }
    }
}
