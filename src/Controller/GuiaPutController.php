<?php

namespace App\Controller;
use App\Entity\GuiaTurismo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GuiaPutController extends AbstractController
{
    #[Route('/guia/put/{uid<\d+>}', name: 'app_guia_put')]
    public function put(Request $request, GuiaTurismo $guia, ManagerRegistry $doctrine): Response
    {
        $form = $this->createFormBuilder($guia)
                ->add("nombre", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("telefono", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el telefono',
                    ])
                    ]
                ])
                ->add("email", EmailType:: class)
                ->add("web", TextType:: class)
                ->add("tipo", TextType:: class)
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $guia = $form->getData();
            
            $entityManager = $doctrine->getManager();
                $entityManager->persist($guia);
                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $this->addFlash("aviso","Guia guardado con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("guia_post/index.html.twig", ['formulario' => $form]);
        }
    }
}
