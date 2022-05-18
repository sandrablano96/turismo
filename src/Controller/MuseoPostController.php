<?php

namespace App\Controller;

use App\Entity\Museo;
use App\Entity\PiezaMuseo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class MuseoPostController extends AbstractController
{
    #[Route('/museo/post', name: 'app_museo_post')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $museo = new Museo();
        $form = $this->createFormBuilder($museo)
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
                ->add("telefono", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el telefono',
                    ])
                    ]
                ])
                ->add("email", EmailType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el email',
                    ])
                    ]
                ])
                ->add("web", TextType:: class)
                ->add("horario", TextType:: class)
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $museo = $form->getData();
            $uuid = Uuid::uuid4();
            $museo->setUuid($uuid->toString());

            $entityManager = $doctrine->getManager();
            $entityManager->persist($museo);
            $entityManager->flush();
            $this->addFlash("aviso","Museo guardado con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("museo_post/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
