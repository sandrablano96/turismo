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
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use  \App\Entity\Museo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class PiezaMuseoPostController extends AbstractController
{
    #[Route('/museo/{uid}/piezas/post', name: 'app_pieza_museo_post')]
    public function post(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, Museo $museo): Response
    {
        $pieza = new PiezaMuseo();
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
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la imagen',
                    ])
                    ]
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pieza = $form->getData();
            $uuid = Uuid::uuid4();
            $pieza->setUid($uuid->toString());
            $pieza->setMuseo($museo);
            
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
                } catch (FileException $e) {
                    console.log($e);
                }
            }    
            $pieza->setImagen($newFilename);
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($pieza);
            $entityManager->flush();
         
            $this->addFlash("aviso","Pieza añadida con éxito");

            return $this->redirectToRoute('admin_museo_get', [
                'uid' => $museo->getUid()
            ]);
        } else{
            return $this->renderForm("Museo/pieza_museo_post/index.html.twig", ['formulario' => $form]);
        }
    }
}
