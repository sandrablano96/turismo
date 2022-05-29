<?php

namespace App\Controller\HGaleria;

use App\Entity\HistoriaImagenes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\File\File;

class HGaleriaPutController extends AbstractController
{
    #[Route('/historia/galeria/put/{uid}', name: 'app_h_galeria_put')]
    public function index(SluggerInterface $slugger, Request $request, ManagerRegistry $doctrine, HistoriaImagenes $galeria): Response
    {
        $galeria->setArchivo(
            new File($this->getParameter('history_directory').'/'.$galeria->getArchivo())
        );
        $form = $this->createFormBuilder($galeria)
                ->add("archivo", FileType:: class, [
                    'data_class' => null,
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

            $entityManager = $doctrine->getManager();
            $entityManager->persist($galeria);
            $entityManager->flush();
            $this->addFlash("aviso","Imagen actualizada con éxito");
            
            $historiaUid = $galeria->getHistoria()->getUid();
            return $this->redirectToRoute('admin_historia_get', [
                'uid' => $historiaUid
            ]);
        }else{
            return $this->renderForm('HGaleria/h_galeria_put/index.html.twig', [
            'formulario' => $form,
        ]);
        }
    }
}
