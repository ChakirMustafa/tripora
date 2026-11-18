<?php

declare(strict_types=1);

namespace App\Controller;

use App\City\GermanCityCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the "Stadt entdecken" search entry point from the homepage.
 *
 * Tripora launches with a curated set of the 24 largest German cities.
 * A match against that list opens the full destination page; anything
 * else guides the visitor back to a supported city.
 */
final class SearchController extends AbstractController
{
    public function __construct(
        private readonly GermanCityCatalog $cityCatalog,
    ) {
    }

    #[Route('/suche', name: 'app_search', methods: ['GET'])]
    public function search(Request $request): Response
    {
        $query = trim((string) $request->query->get('city', ''));

        if ('' === $query) {
            $this->addFlash('notice', 'Bitte gib zuerst eine Stadt ein — versuch es mit „Berlin“ oder „Leipzig“.');

            return $this->redirectToRoute('app_home');
        }

        $city = $this->cityCatalog->findByName($query);

        if (null === $city) {
            $this->addFlash('notice', sprintf(
                '„%s“ ist noch nicht dabei — wir starten mit den 24 größten Städten Deutschlands. Wähl eine davon aus der Liste.',
                $query,
            ));

            return $this->redirectToRoute('app_home');
        }

        return $this->redirectToRoute('app_city', ['slug' => $city->slug]);
    }
}
