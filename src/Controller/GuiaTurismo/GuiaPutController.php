<?php


namespace App\Controller\GuiaTurismo;
use App\Entity\GuiaTurismo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GuiaPutController extends AbstractController
{
    #[Route('/guia/put/{uid}', name: 'app_guia_put')]
    public function put(Request $request, GuiaTurismo $guia, ManagerRegistry $doctrine): Response
    {
        $form = $this->createFormBuilder($guia)
                ->add("nombre", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
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
                ->add("email", EmailType:: class)
                ->add("paginaWeb", TextType:: class)
                ->add("tipo", TextType:: class)
                
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $guia = $form->getData();
            
            $entityManager = $doctrine->getManager();
                $entityManager->persist($guia);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->clear();
                $this->addFlash("aviso","Guia guardado con éxito");

            return $this->redirectToRoute("admin_guias_get");
        } else{
            return $this->renderForm("Guia/guia_post/index.html.twig", ['formulario' => $form]);
        }
    }
}
