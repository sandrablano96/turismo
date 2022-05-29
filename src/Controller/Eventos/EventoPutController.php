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


class EventoPutController extends AbstractController
{
    #[Route('/evento/put/{uid}', name: 'app_evento_put')]
    public function put(ManagerRegistry $doctrine, Evento $evento, Request $request): Response
    {
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
            /****************************************/
            $evento->setImagen('ALAAAA');
            /****************************************/
            $entityManager = $doctrine->getManager();
            $entityManager->persist($evento);
            $entityManager->flush();
            $this->addFlash("aviso","Evento actualizzado con éxito");

            return $this->redirectToRoute("admin_eventos_get");
        } else{
            return $this->renderForm("Eventos/evento_put/index.html.twig", ['formulario' => $form]);
        }
    }
}
