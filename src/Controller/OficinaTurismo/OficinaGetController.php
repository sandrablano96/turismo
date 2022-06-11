<?php

namespace App\Controller\OficinaTurismo;

use App\Entity\Consulta;
use App\Entity\OficinaTurismo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Ramsey\Uuid\Uuid;

class OficinaGetController extends AbstractController {
    
    /**
     * @Route("/oficina/{uid}", name="app_oficina_get", options={"expose"=true}, methods={"GET", "POST"})
     */
    public function get(OficinaTurismo $oficina, Request $request, ManagerRegistry $doctrine): Response {
        $consulta = new Consulta();
        $form = $this->createFormBuilder($consulta)
                ->add("nombre", TextType:: class, [
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Nombre'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca su nombre',
                                ])
                    ]
                ])
                ->add("email", EmailType:: class, [
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Email'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca su email',
                                ])
                    ]
                ])
                ->add("telefono", TelType:: class, [
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Telefono'
                    ),
                ])
                ->add("asunto", TextType:: class, [
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Asunto'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca el asunto',
                                ])
                    ]
                ])
                ->add("consulta", TextareaType:: class, [
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Escribe aqui tu consulta, te responderemos lo más rápido posible'
                    ),
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Introduzca su consulta',
                                ])
                    ]
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $consulta = $form->getData();
            $uuid = Uuid::uuid4();
            $consulta->setUid($uuid);
            $em->persist($consulta);
            $em->flush();
            $response = array('code' => 200);
            return new JsonResponse($response);
        }
        if ($request->isXmlHttpRequest()) {
            return $this->renderForm('Oficina/oficina_post/_consulta.html.twig', [
                        'formulario' => $form,
            ]);
        }
        
        return $this->renderForm('Oficina/oficina_get/index.html.twig', [
                    'oficina' => $oficina, 'formulario' => $form
                ]);
    }

    /**
     * @Route("/admin/oficina/{uid}", name="admin_oficina_get")
     */
    public function getOffice(OficinaTurismo $oficina): Response {
        return $this->render('admin/admin_oficina.html.twig', [
                    'oficina' => $oficina
        ]);
    }

    /**
     * @Route("/oficina/{uid}/consulta", name="app_oficina_consulta", options={"expose"=true}, methods={"POST"})
     */
    public function consulta(Request $request, ManagerRegistry $doctrine): Response {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $nombre = $parametersAsArray['nombre'];
            $email = $parametersAsArray['email'];
            $tel = $parametersAsArray['telefono'];
            $asunto = $parametersAsArray['asunto'];
            $consulta = $parametersAsArray['consulta'];
            $nameSanitized = filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS);
            $emailSanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
            $telSanitized = filter_var($asunto, FILTER_SANITIZE_SPECIAL_CHARS);
            $asuntoSanitized = filter_var($asunto, FILTER_SANITIZE_SPECIAL_CHARS);
            $consultaSanitized = filter_var($consulta, FILTER_SANITIZE_SPECIAL_CHARS);

            $consulta = new Consulta();
            $consulta->setNombre($nameSanitized);
            $consulta->setEmail($emailSanitized);
            $consulta->setTelefono($telSanitized);
            $consulta->setAsunto($asuntoSanitized);
            $consulta->setConsulta($consultaSanitized);

            $uuid = Uuid::uuid4();
            $consulta->setUid($uuid->toString());
            $entityManager = $doctrine->getManager();

            $entityManager->persist($consulta);
            $entityManager->flush();
            $response = array("code" => 200,
                    "mensaje" => 'Su consulta ha sido enviada correctamente');
        }
            $response = array("code" => 500,
                    "mensaje" => 'Su consulta ha sido enviada correctamente');



        return new JsonResponse($response);
    }

}
