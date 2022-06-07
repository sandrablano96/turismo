<?php

namespace App\Controller\Usuario;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Usuario;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UpdateUserInfoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted("ROLE_USER")
 */
class UsuarioPutController extends AbstractController {

    #[Route('/usuario/{uid}', name: 'app_usuario_put')]
    public function put(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Usuario $usuario): Response {
        $form = $this->createForm(UpdateUserInfoType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            if ($form->get('plainPassword')->getData() != null) {
                $usuario->setPassword(
                        $userPasswordHasher->hashPassword(
                                $usuario,
                                $form->get('plainPassword')->getData()
                        )
                );
            }else{
                $usuario->setPassword($usuario->getPassword());
            }


            $entityManager->persist($usuario);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_usuario_get', [
                        'uid' => $usuario->getUid()
            ]);
        }

        return $this->render('Usuario/usuario_put/index.html.twig', [
                    'registrationForm' => $form->createView(),
        ]);
    }

}
