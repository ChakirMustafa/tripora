<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Renders the login form and provides the logout route.
 *
 * The actual credential check is handled by the "form_login"
 * configuration of the main firewall (see config/packages/security.yaml).
 */
final class SecurityController extends AbstractController
{
    #[Route('/anmelden', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_account');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/abmelden', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \LogicException('This route is intercepted by the logout key on the firewall.');
    }
}
