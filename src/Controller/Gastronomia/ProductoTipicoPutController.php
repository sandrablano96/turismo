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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class ProductoTipicoPutController extends AbstractController
{
    #[Route('/gastronomia/producto/put/{uid}', name: 'app_producto_tipico_put')]
    public function put(ProductoTipico $producto, Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $imagen = $producto->getImagen();
        $producto->setImagen(
            new File($this->getParameter('gastronomy_directory').'/'.$producto->getImagen())
        );
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
                ->add("imagen", FileType:: class, [
                    'mapped' => false,
                    'required' => false,
                    'data_class' => null,
                ])
                
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producto = $form->getData();
            
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
                     $producto->setImagen($newFilename);
                } catch (FileException $e) {
                    console.log($e);
                }
            } else{
                $producto->setImagen($imagen);
            }   
          
            $entityManager = $doctrine->getManager();
            $entityManager->persist($producto);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash("aviso","Producto actualizado con éxito");
            
            $gastronomiaUid = $producto->getGastronomia()->getUid();
            return $this->redirectToRoute('admin_gastronomia_get', [
                'uid' => $gastronomiaUid
            ]);
        }else{
            return $this->renderForm('Gastronomia/producto_tipico_put/index.html.twig', [
            'formulario' => $form,'imagen' => $imagen, 'alt' => $producto->getNombre()
        ]);
        }
    }
}
