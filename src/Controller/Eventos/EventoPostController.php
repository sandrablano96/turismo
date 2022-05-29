<?php

namespace App\Controller\Eventos;

use App\Entity\Evento;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\FileType;
use Ramsey\Uuid\Uuid;

class EventoPostController extends AbstractController
{
    #[Route('/evento/post', name: 'app_evento_post')]
    public function post(ManagerRegistry $doctrine, Request $request): Response
    {
        $evento = new Evento();
        $form = $this->createFormBuilder($evento)
                ->add("titulo", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el titulo',
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
                ->add("fecha", DateType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la fecha en la que se celebra el evento',
                    ])
                    ]
                ])
                ->add("precio", TextType:: class)
                ->add("tipo_evento", ChoiceType:: class, [
                        'choices' => [
                            'Evento deportivo' => 'deportivo',
                            'Evento cultural' => 'cultural', 
                            'Tradiciones y fiestas' => 'tradiciones'
                        ]

                ])
                //-add("imagen", FileType::class)
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();
            $uuid = Uuid::uuid4();
            $evento->setUid($uuid->toString());
            /****************************************/
            $evento->setImagen('ALAAAA');
            /****************************************/

            $entityManager = $doctrine->getManager();
            $entityManager->persist($evento);
            $entityManager->flush();
            $this->addFlash("aviso","Evento guardado con éxito");

            return $this->redirectToRoute("admin_eventos_get");
        } else{
            return $this->renderForm("Eventos/evento_post/index.html.twig", ['formulario' => $form]);
        }
    }
}
