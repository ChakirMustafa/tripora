<?php

declare(strict_types=1);

namespace App\Controller;

use App\City\GermanCityCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Signed-in user area. Guarded by the "^/konto" rule in security.yaml.
 */
final class AccountController extends AbstractController
{
    #[Route('/konto', name: 'app_account', methods: ['GET'])]
    public function index(GermanCityCatalog $cityCatalog): Response
    {
        return $this->render('account/index.html.twig', [
            'popular_cities' => $cityCatalog->popular(6),
        ]);
    }
}
