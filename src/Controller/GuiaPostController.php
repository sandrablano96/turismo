<?php

namespace App\Controller;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\GuiaTurismo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ramsey\Uuid\Uuid;

class GuiaPostController extends AbstractController
{

    #[Route('/guia/post', name: 'app_guia_post')]
    public function post(Request $request, ManagerRegistry $doctrine): Response
    {
        $guia = new GuiaTurismo();
        $form = $this->createFormBuilder($guia)
                ->add("nombre", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
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
                ->add("tipo", TextType:: class)
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $guia = $form->getData();
            $uuid = Uuid::uuid4();
            $guia->setUid($uuid->toString());
            $entityManager = $doctrine->getManager();
                $entityManager->persist($guia);
                $entityManager->flush();
                $this->addFlash("aviso","Guia guardado con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("guia_post/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
