<?php


namespace App\Controller\VisitaGuiada;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\GuiaTurismo;
use App\Entity\OficinaTurismo;
use App\Entity\VisitaGuiada;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class VisitaPutController extends AbstractController
{
    #[Route('/visita/put/{uid}', name: 'app_visita_put')]
    public function put(Request $request, ManagerRegistry $doctrine, VisitaGuiada $visita): Response
    {
        $guias = $doctrine->getRepository(GuiaTurismo::class)->findAll();
        $form = $this->createFormBuilder($visita)
                ->add("titulo", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el titlo de la visita',
                    ])
                    ]
                ])
                ->add("fecha", DateTime:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la fecha',
                    ])
                    ]
                ])
                ->add("descripción", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una breve descripción',
                    ])
                    ]
                ])
                ->add("precio", TextType:: class)
                ->add("oficina_turismo_id", EntityType::class, [
                        'class' => OficinaTurismo::class,
                        'expanded' => true,
                        'multiple' => true,
                ])
                ->add('guia_turismo_id', EntityType::class, [
                    'class' => OficinaTurismo::class,
                    'choices' => $guias, 
                    'choice_label' => 'nombre', 
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
            $visita = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($visita);
            $entityManager->flush();
            $this->addFlash("aviso","Visita guiada actualizada con éxito");

            return $this->redirectToRoute("");
        } else{
            return $this->renderForm("visita_put/index.html.twig", ['formulario' => $form]);
        }
    }
}
