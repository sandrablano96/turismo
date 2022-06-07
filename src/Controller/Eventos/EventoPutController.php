<?php

namespace App\Controller\Eventos;

use App\Entity\Evento;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use \Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */

class EventoPutController extends AbstractController
{
    #[Route('/evento/put/{uid}', name: 'app_evento_put')]
    public function put(ManagerRegistry $doctrine, Evento $evento, Request $request,  SluggerInterface $slugger): Response
    {
        $imagen = $evento->getImagen();
        if($evento->getImagen() != null){
            $evento->setImagen(
            new File($this->getParameter('events_directory').'/'.$evento->getImagen())
                    
        );
        }
        
        $form = $this->createFormBuilder($evento)
                ->add("titulo", TextType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el titulo',
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
                ->add("fecha", DateType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la fecha en la que se celebra el evento',
                    ])
                    ]
                ])
                ->add("precio", TextType::class, [
                    'required' => false
                ])
                ->add("tipo_evento", ChoiceType::class, [
                        'choices' => [
                            'Evento deportivo' => 'deportivo',
                            'Evento cultural' => 'cultural', 
                            'Tradiciones y fiestas' => 'tradiciones'
                        ]

                ])
                ->add("imagen", FileType::class, [
                    'required' => false,
                    'data_class' => null,
                    'mapped' => false
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();
            
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
                    
                } catch (FileException $e) {
                    console.log($e);
                }
                $evento->setImagen($newFilename);
            }else{
                $evento->setImagen($imagen);
            }    
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($evento);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash("aviso","Evento actualizzado con éxito");

            return $this->redirectToRoute("admin_eventos_get");
        } else{
            return $this->renderForm("Eventos/evento_put/index.html.twig", ['formulario' => $form, 'imagen' => $imagen, 'alt' => $evento->getTitulo()]);
        }
    }
}
