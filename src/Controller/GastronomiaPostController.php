<?php

namespace App\Controller;
use App\Entity\Gastronomia;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\ProductoTipico;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ramsey\Uuid\Uuid;

class GastronomiaPostController extends AbstractController
{
    #[Route('/gastronomia/post', name: 'app_gastronomia_post')]
    public function post(Request $request,ManagerRegistry $doctrine, Gastronomia $gastronomia): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $gastronomia = new Gastronomia();
        $form = $this->createFormBuilder($gastronomia)
                ->add('descripcion', TextType::class, [
                    'required' => true,
                    'constraints' => [
                    new NotBlank([
                        'message' => 'La descripción no puede quedar vacía',
                    ])
                    ]
                ])
                ->add('producto', ProductoTipico::class, [
                    'required' => true
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gastronomia = $form->getData();
            $uuid = Uuid::uuid4();
            $gastronomia->setUid($uuid->toString());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($gastronomia);
            $entityManager->flush();
            $this->addFlash("aviso","Gastronomia y productos agregados correctamente");
        }
            return $this->redirectToRoute("");
        
    }
    
}
