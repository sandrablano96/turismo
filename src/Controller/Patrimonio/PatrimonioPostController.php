<?php

namespace App\Controller\Patrimonio;

use App\Entity\Patrimonio;
use App\Entity\TipoPatrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\String\Slugger\SluggerInterface;

class PatrimonioPostController extends AbstractController
{
    #[Route('/patrimonio/{type}/post', name: 'app_patrimonio_post')]
    public function post(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, String $type): Response
    {
        $tipos = $doctrine->getRepository(TipoPatrimonio::class)->findAll();
        $patrimonio = new Patrimonio();
         $form = $this->createFormBuilder($patrimonio)
                ->add("nombre", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("direccion", TextType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la dirección',
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
                ->add("email", EmailType:: class, ['required' => false])
                ->add("web", TextType:: class, ['required' => false])
                ->add("horario", TextareaType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el horario de visita',
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
                ->add("imagen", FileType:: class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca una imagen',
                    ])
                    ]
                ])
                ->add("precio", TextareaType:: class, ['required'=>false])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patrimonio = $form->getData();
            $uuid = Uuid::uuid4();
            $patrimonio->setUid($uuid->toString());
            
            $typeId = $type === 'cultural' ? 2 : 1;
            $tipoPatrimonio = $doctrine->getRepository(TipoPatrimonio::class)->find($typeId);
            $patrimonio->setTipo($tipoPatrimonio);
            
            $foto = $form->get('imagen')->getData();
            //subimos la imagen
            if ($foto) {
                $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $foto->move($this->getParameter('heritage_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    console.log($e);
                }
                $patrimonio->setImagen($newFilename);
            }    

            $entityManager = $doctrine->getManager();
                $entityManager->persist($patrimonio);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->clear();
                $this->addFlash("aviso","Registro guardado con éxito");

            return $this->redirectToRoute("admin_patrimonio_tipo_get", ['type' => $type]);
        } else{
            return $this->renderForm("Patrimonio/patrimonio_post/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
