<?php

namespace App\Controller\Patrimonio;

use App\Entity\Patrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TipoPatrimonio;

class PatrimonioPutController extends AbstractController
{
    #[Route('/patrimonio/put/{uid}', name: 'app_patrimonio_put')]
    public function put(ManagerRegistry $doctrine, Request $request, Patrimonio $patrimonio): Response
    {
        $tipos = $doctrine->getRepository(TipoPatrimonio::class)->findAll();

        $form = $this->createFormBuilder($patrimonio)
                ->add("nombre", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("direccion", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la dirección',
                    ])
                    ]
                ])
                ->add("telefono", TelType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el telefono',
                    ])
                    ]
                ])
                ->add("email", EmailType:: class)
                ->add("web", TextType:: class)
                ->add("horario", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el horario de visita',
                    ])
                    ]
                ])
                ->add("descripcion", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una breve descripción',
                    ])
                    ]
                ])
//                ->add("imagen", FileType:: class, [
//                    'required' => true,
//                    'constraints' => [
//                    new NotBlank([
//                        'message' => 'Introduzca una imagen',
//                    ])
//                    ]
//                ])
                ->add("precio", TextareaType:: class)
                ->add('enviar', SubmitType::class)
                ->add('tipo', EntityType::class, [
                    'required' => true,
                    'class' => TipoPatrimonio::class,
                    'choices' => $tipos, 
                    'choice_label' => 'tipo', 
                    'choice_value' => 'id', 
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Seleccione un tipo',
                    ])
            ]
                ])
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patrimonio = $form->getData();
                        /****************************************/
            $patrimonio->setImagen('ALAAAA');
            /****************************************/
            $entityManager = $doctrine->getManager();
                $entityManager->persist($patrimonio);
                $entityManager->flush();
                $this->addFlash("aviso","Registro actualizado con éxito");

            return $this->redirectToRoute("admin_patrimonio_get");
        } else{
            return $this->renderForm("Patrimonio/patrimonio_put/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
