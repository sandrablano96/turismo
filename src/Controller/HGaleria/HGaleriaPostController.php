<?php

namespace App\Controller\HGaleria;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\HistoriaImagenes;
use Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use App\Entity\Historia;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class HGaleriaPostController extends AbstractController
{
    #[Route('/historia/{uid}/galeria/post', name: 'app_h_galeria_post')]
    public function index(SluggerInterface $slugger, Request $request, ManagerRegistry $doctrine, Historia $historia): Response
    {
        $galeria = new HistoriaImagenes();
        $form = $this->createFormBuilder($galeria)
                ->add("archivo", FileType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una imagen',
                    ])
                    ]
                ])
                ->add("alt", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una breve descripción de la imagen',
                    ])
                    ]
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $galeria = $form->getData();
            $uuid = Uuid::uuid4();
            $galeria->setUid($uuid->toString());
            $foto = $form->get('archivo')->getData();
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
            $galeria->setArchivo($newFilename);
            $galeria->setHistoria($historia);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($galeria);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash("aviso","Imagen añadida con éxito");
            
            return $this->redirectToRoute('admin_historia_get', [
                'uid' => $historia->getUid()
            ]);
        }else{
            return $this->renderForm('HGaleria/h_galeria_post/index.html.twig', [
            'formulario' => $form,
        ]);
        }
        
    }
}
