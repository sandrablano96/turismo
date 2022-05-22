<?php

namespace App\Controller\Museo;
use App\Entity\Museo;
use App\Form\PiezaType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MuseoPutController extends AbstractController
{
    #[Route('/museo/put/{uid}', name: 'app_museo_put')]
    public function put(Museo $museo, Request $request, ManagerRegistry $doctrine): Response
    {
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
                ->add("telefono", TelType:: class, [
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
                ->add('piezas', CollectionType::class, [
                    'entry_type' => PiezaType::class])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $museo = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($museo);
            $entityManager->flush();
            $this->addFlash("aviso","Museo actualizado con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("Museo/museo_put/index.html.twig", ['formulario' => $form]);
        }
    }
}
