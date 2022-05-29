<?php

namespace App\Controller\OficinaTurismo;

use App\Entity\OficinaTurismo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OficinaPutController extends AbstractController
{
    #[Route('/oficina/put/{uid}', name: 'app_oficina_put')]
    public function put(ManagerRegistry $doctrine, OficinaTurismo $oficina, Request $request): Response
    {
        $form = $this->createFormBuilder($oficina)
                ->add("direccion", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la direccion',
                    ])
                    ]
                ])
                ->add("telefono", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el télefono de contacto',
                    ])
                    ]
                ])
                ->add("horario", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el horario de la oficina',
                    ])
                    ]
                ])
                ->add("localidad", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la localidad de la oficina',
                    ])
                    ]
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oficina = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($oficina);
            $entityManager->flush();
            $this->addFlash("aviso","Datos de la oficina actualizados con éxito");

            return $this->redirectToRoute("admin_oficina_get");
        } else{
            return $this->renderForm("Oficina/oficina_put/index.html.twig", ['formulario' => $form]);
        }
    }
}
