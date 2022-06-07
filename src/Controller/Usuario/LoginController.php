<?php

namespace App\Controller\Usuario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
      {
        if($this->getUser() != null){
            $this->redirectToRoute("app_main_menu");
        }
        // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('login/login.html.twig', [
             'last_username' => $lastUsername,
             'error'         => $error,
          ]);
    }
    
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void{
        
    }
    
    
    
}
