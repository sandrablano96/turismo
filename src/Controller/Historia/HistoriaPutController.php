<?php

namespace App\Controller\Historia;

use App\Entity\Historia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;


class HistoriaPutController extends AbstractController
{
    #[Route('/historia/put/{uid}', name: 'app_historia_put')]
    public function put(ManagerRegistry $doctrine, Historia $historia, Request $request): Response
    {
        $historia = new Historia();
        $form = $this->createFormBuilder($historia)
                ->add("historia", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el texto que desea mostrar en la página de historia',
                    ])
                    ]
                ])
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $historia = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($historia);
            $entityManager->flush();
            $this->addFlash("aviso","Historia de la localidad actualizada con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("Historia/historia_put/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
