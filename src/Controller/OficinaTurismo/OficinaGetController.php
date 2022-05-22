<?php

namespace App\Controller\OficinaTurismo;

use App\Entity\Contacto;
use App\Entity\OficinaTurismo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class OficinaGetController extends AbstractController {

    #[Route('/oficina/{uid}', name: 'app_oficina_get')]
    public function get(OficinaTurismo $oficina, Request $request, ManagerRegistry $doctrine): Response {
        $contacto = new Contacto();
        $form = $this->createFormBuilder($contacto)
                ->add("nombre", TextType:: class, [
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                    'placeholder' => 'Nombre'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca su nombre',
                                ])
                    ]
                ])
                ->add("email", EmailType:: class, [
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                    'placeholder' => 'Email'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca su email',
                                ])
                    ]
                ])
                ->add("telefono", TelType:: class, [
                    'label' => false,
                    'attr' => array(
                    'placeholder' => 'Telefono'
                    ),
                ])
                ->add("asunto", TextType:: class, [
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                    'placeholder' => 'Asunto'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca el asunto',
                                ])
                    ] 
                ])
                ->add("consulta", TextareaType:: class, [
                    'label' => false,
                    'attr' => array(
                    'placeholder' => 'Escribe aqui tu consulta, te responderemos lo más rápido posible'
                    ),
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca su consulta',
                                ])
                    ]  
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contacto = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($contacto);
            $entityManager->flush();
            $this->addFlash("aviso", "Tu consulta se ha procesado con éxito");

            return $this->redirectToRoute("app_oficina_get");
        } else {
            return $this->renderForm('Oficina/oficina_get/index.html.twig', [
                    'oficina' => $oficina, 'formulario' => $form ]);
        }
        
    }

}
