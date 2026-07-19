<?php

declare(strict_types=1);

namespace App\Controller;

use App\City\GermanCityCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Renders the public marketing homepage.
 */
final class HomeController extends AbstractController
{
    public function __construct(
        private readonly GermanCityCatalog $cityCatalog,
    ) {
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        $allCities = $this->cityCatalog->all();
        $popularCities = $this->cityCatalog->popular(12);

        return $this->render('home/index.html.twig', [
            'cities' => $allCities,
            'popular_cities' => $popularCities,
            'cities_data' => array_map(static fn ($city) => $city->toArray(), $allCities),
            'popular_slugs' => array_map(static fn ($city) => $city->slug, $popularCities),
        ]);
    }
}
