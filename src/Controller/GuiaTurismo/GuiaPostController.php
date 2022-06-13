<?php


namespace App\Controller\GuiaTurismo;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\GuiaTurismo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class GuiaPostController extends AbstractController
{

    #[Route('/guias/post', name: 'app_guia_post')]
    public function post(Request $request, ManagerRegistry $doctrine): Response
    {
        $guia = new GuiaTurismo();
        $form = $this->createFormBuilder($guia)
                ->add("nombre", TextType:: class, [
                    'label' => 'Nombre*',
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el nombre',
                    ])
                    ]
                ])
                ->add("telefono", TelType:: class, [
                    'label' => 'Teléfono*',
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el telefono',
                    ])
                    ]
                ])
                ->add("email", EmailType:: class, [
                    'label' => 'Email',
                ])
                ->add("paginaWeb", UrlType:: class, [
                    'label' => 'Página web',
                ])
                ->add("tipo", TextType:: class, [
                    'required' => true,
                    'label' => 'Tipo*',
                    'attr' => array(
                    'placeholder' => 'Particular/Empresa'
      )
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $guia = $form->getData();
            $uuid = Uuid::uuid4();
            $guia->setUid($uuid->toString());
            $entityManager = $doctrine->getManager();
                $entityManager->persist($guia);
                $entityManager->flush();
         
                $this->addFlash("aviso","Guia guardado con éxito");

            return $this->redirectToRoute("app_visita_post");
        } else{
            return $this->renderForm("Guia/guia_post/index.html.twig", ['formulario' => $form]);
        }
    
    }
}
