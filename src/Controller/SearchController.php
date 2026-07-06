<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the "explore a city" search entry point from the homepage.
 *
 * The full search & discovery experience (attractions, restaurants,
 * itineraries, etc.) is planned for a follow-up iteration. For now this
 * controller validates the input and shows a friendly holding page so the
 * homepage's primary call-to-action leads somewhere real.
 */
final class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET'])]
    public function search(Request $request): Response
    {
        $city = trim((string) $request->query->get('city', ''));

        if ('' === $city) {
            $this->addFlash('notice', 'Tell us a city first — try "Berlin" or "Tokyo".');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('search/results.html.twig', [
            'city' => $city,
        ]);
    }
}
