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
use Symfony\Component\HttpFoundation\File\File;
use \Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\TipoPatrimonio;

class PatrimonioPutController extends AbstractController
{
    #[Route('/patrimonio/{type}/put/{uid}', name: 'app_patrimonio_put')]
    public function put(ManagerRegistry $doctrine, Request $request, Patrimonio $patrimonio, SluggerInterface $slugger, String $type): Response
    {
        $imagen = $patrimonio->getImagen();
        $patrimonio->setImagen(
            new File($this->getParameter('heritage_directory').'/'.$patrimonio->getImagen())
        );
        $tipos = $doctrine->getRepository(TipoPatrimonio::class)->findAll();

        $form = $this->createFormBuilder($patrimonio)
                ->add("nombre", TextType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("direccion", TextType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la dirección',
                    ])
                    ]
                ])
                ->add("telefono", TelType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el telefono',
                    ])
                    ]
                ])
                ->add("email", EmailType::class, ['required' => false])
                ->add("web", TextType::class, ['required' => false])
                ->add("horario", TextareaType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el horario de visita',
                    ])
                    ]
                ])
                ->add("descripcion", TextareaType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una breve descripción',
                    ])
                    ]
                ])
                
                ->add("precio", TextareaType::class, ['required' => false])
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
                ->add("imagen", FileType::class, [
                   'data_class' => null,
                    'required' => false,
                    'mapped' => false
                ])
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patrimonio = $form->getData();
            $foto = $form->get('imagen')->getData();
            //subimos la imagen
            if ($foto) {
                $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $foto->move($this->getParameter('events_directory'),
                        $newFilename
                    );
                    $patrimonio->setImagen($newFilename);
                } catch (FileException $e) {
                    console.log($e);
                }
            }else{
                $patrimonio->setImagen($imagen);
            }    
            
            $entityManager = $doctrine->getManager();
                $entityManager->persist($patrimonio);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->clear();
                $this->addFlash("aviso","Registro actualizado con éxito");

            return $this->redirectToRoute("admin_patrimonio_tipo_get", ['type' => $type]);
        } else{
            return $this->renderForm("Patrimonio/patrimonio_put/index.html.twig", ['formulario' => $form, 'imagen' => $imagen, 'alt' => $patrimonio->getNombre()]);
        }
    
    }
}
