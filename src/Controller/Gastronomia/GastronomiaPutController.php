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
        $form = $this->createFormBuilder($gastronomia)
                ->add('descripcion', TextareaType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'La descripción no puede quedar vacía',
                    ])
                    ]
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gastronomia = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($gastronomia);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash("aviso","Gastronomia actualizada correctamente");
            return $this->redirectToRoute('admin_gastronomia_get', [
                'uid' => $gastronomia->getUid()
            ]);
        }else{
            return $this->renderForm("Gastronomia/gastronomia_put/index.html.twig", ['formulario' => $form]);
        }
    }
}
