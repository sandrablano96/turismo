<?php

namespace App\Controller\Patrimonio;

use App\Entity\Patrimonio;
use App\Entity\TipoPatrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PatrimonioPostController extends AbstractController
{
    #[Route('/patrimonio/post', name: 'app_patrimonio_post')]
    public function post(Request $request, ManagerRegistry $doctrine): Response
    {
        $tipos = $doctrine->getRepository(TipoPatrimonio::class)->findAll();
        $patrimonio = new Patrimonio();
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
                ->add("imagen", FileType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una imagen',
                    ])
                    ]
                ])
                ->add("precio", TextareaTypeType:: class)
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
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patrimonio = $form->getData();
            $uuid = Uuid::uuid4();
            $patrimonio->setUid($uuid->toString());
            $entityManager = $doctrine->getManager();
                $entityManager->persist($patrimonio);
                $entityManager->flush();
                $this->addFlash("aviso","Registro guardado con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("patrimonio_post/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
