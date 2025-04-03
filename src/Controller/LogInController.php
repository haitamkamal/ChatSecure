<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogInController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {


        if($this->getUser()){
            return $this->redirectToRoute('app_user');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
public function logout(Request $request): Response
    {
        // Log session and cookie details before clearing
        $this->logger->info('User logging out', [
            'session_id' => $request->getSession()->getId(),
            'remember_me_cookie' => $request->cookies->get('remember_me'),
        ]);

        // Clear the session
        $session = $request->getSession();
        $session->invalidate();

        // Clear the remember me cookie
        $response = new Response();
        $response->headers->clearCookie('remember_me');

        // Redirect to the homepage or login page
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER, $response);
    }
}
