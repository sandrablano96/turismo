<?php

namespace App\Controller\Historia;

use App\Entity\Historia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;


class HistoriaPutController extends AbstractController
{
    #[Route('/historia/put/{uid}', name: 'app_historia_put')]
    public function put(ManagerRegistry $doctrine, Historia $historia, Request $request): Response
    {
        $historia->setImagen(
            new File($this->getParameter('history_directory').'/'.$galeria->getImagen())
        );
        $form = $this->createFormBuilder($historia)
                ->add("historia", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el texto que desea mostrar en la página de historia',
                    ])
                    ]
                ])
                ->add('imagen', FileType:: class, [
                    'required' => true,
                    'data_class' => null,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el texto que desea mostrar en la página de historia',
                    ])
                    ]
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $historia = $form->getData();
            $foto = $form->get('imagen')->getData();
            //subimos la imagen
            if ($foto) {
                $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $foto->move($this->getParameter('history_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    console.log($e);
                }
            }    
            $historia->setImagen($newFilename);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($historia);
            $entityManager->flush();
            $this->addFlash("aviso","Historia de la localidad actualizada con éxito");

            return $this->redirectToRoute("admin_historia_get");
        } else{
            return $this->renderForm("Historia/historia_put/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
