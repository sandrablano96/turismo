<?php

namespace App\Controller\Gastronomia;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gastronomia;
use App\Entity\ProductoTipico;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Ramsey\Uuid\Uuid;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class ProductoTipicoPostController extends AbstractController
{
    #[Route('/gastronomia/{uid}/producto/post', name: 'app_producto_tipico_post')]
    public function post(Gastronomia $gastronomia, Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
       $producto = new ProductoTipico();
        $form = $this->createFormBuilder($producto)
                ->add("nombre", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("descripcion", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("receta", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una receta',
                    ]), 
                        'placeholder' => 'Link a la receta'
                    ]
                ])
                ->add("imagen", FileType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una imagen',
                    ])
                    ]
                ])
                
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producto = $form->getData();
            $uuid = Uuid::uuid4();
            $producto->setUid($uuid->toString());
            $foto = $form->get('imagen')->getData();
            //subimos la imagen
            if ($foto) {
                $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $foto->move($this->getParameter('gastronomy_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    console.log($e);
                }
            }    
            $producto->setImagen($newFilename);
            $producto->setGastronomia($gastronomia);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($producto);
            $entityManager->flush();
     
            $this->addFlash("aviso","Producto añadido con éxito");
            
            return $this->redirectToRoute('admin_gastronomia_get', [
                'uid' => $gastronomia->getUid()
            ]);
        }else{
            return $this->renderForm('Gastronomia/producto_tipico_post/index.html.twig', [
            'formulario' => $form,
        ]);
        }
    }
}
