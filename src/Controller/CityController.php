<?php

declare(strict_types=1);

namespace App\Controller;

use App\City\CityGuide;
use App\City\GermanCityCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Full destination page for a single city, reached from a listing card
 * or the search box (see SearchController).
 */
final class CityController extends AbstractController
{
    public function __construct(
        private readonly GermanCityCatalog $cityCatalog,
        private readonly CityGuide $cityGuide,
    ) {
    }

    #[Route('/stadt/{slug}', name: 'app_city', methods: ['GET'], requirements: ['slug' => '[a-z0-9-]+'])]
    public function show(string $slug): Response
    {
        $city = $this->cityCatalog->findBySlug($slug);

        if (null === $city) {
            throw $this->createNotFoundException(sprintf('Die Stadt „%s“ ist nicht verfügbar.', $slug));
        }

        $highlights = $this->cityGuide->highlights($slug);
        $categories = $this->cityGuide->categoriesFor($highlights);

        $otherCities = array_values(array_filter(
            $this->cityCatalog->all(),
            static fn ($candidate) => $candidate->slug !== $city->slug,
        ));

        return $this->render('city/show.html.twig', [
            'city' => $city,
            'highlights' => $highlights,
            'categories' => $categories,
            'other_cities' => \array_slice($otherCities, 0, 6),
        ]);
    }
}
