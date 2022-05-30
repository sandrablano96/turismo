<?php

namespace App\Controller\Museo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PiezaMuseo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;

class PiezaMuseoPutController extends AbstractController
{
    #[Route('/museo/piezas/put/{uid}', name: 'app_pieza_museo_put')]
    public function index(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, PiezaMuseo $pieza): Response
    {
        $imagen = $pieza->getImagen();
        $pieza->setImagen(
            new File($this->getParameter('museum_directory').'/'.$pieza->getImagen())
        );
        $form = $this->createFormBuilder($pieza)
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
                ->add("epoca", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la época',
                    ])
                    ]
                ])
                ->add("imagen", FileType::class, [
                    'data_class' => null,
                    'required' => false,
                    'mapped' => false
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pieza = $form->getData();
            
            $foto = $form->get('imagen')->getData();
            //subimos la imagen
            if ($foto) {
                $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $foto->move($this->getParameter('museum_directory'),
                        $newFilename
                    );
                    $pieza->setImagen($newFilename);
                } catch (FileException $e) {
                    console.log($e);
                }
            }else{
                $pieza->setImagen($imagen);
            }  
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($pieza);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->clear();
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash("aviso","Pieza añadida con éxito");

            return $this->redirectToRoute('admin_museo_get', [
                'uid' => $pieza->getMuseo()->getUid()
            ]);
        } else{
            return $this->renderForm("Museo/pieza_museo_put/index.html.twig", ['formulario' => $form, 'imagen' => $imagen, 'alt' => $pieza->getTitulo()]);
        }
    }
}
