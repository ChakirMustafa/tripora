<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Renders the public marketing homepage.
 */
final class HomeController extends AbstractController
{
    /**
     * A short, curated list of cities featured on the homepage.
     * In a future iteration this will be replaced by a database-backed
     * "popular destinations" service.
     */
    private const array FEATURED_CITIES = [
        ['name' => 'Berlin', 'country' => 'Germany', 'tagline' => 'Art, history & nightlife', 'places' => 482, 'accent' => 'violet'],
        ['name' => 'Tokyo', 'country' => 'Japan', 'tagline' => 'Neon streets & quiet temples', 'places' => 611, 'accent' => 'teal'],
        ['name' => 'Lisbon', 'country' => 'Portugal', 'tagline' => 'Hills, tiles & ocean light', 'places' => 337, 'accent' => 'coral'],
        ['name' => 'New York', 'country' => 'USA', 'tagline' => 'A city block for everything', 'places' => 705, 'accent' => 'indigo'],
        ['name' => 'Bangkok', 'country' => 'Thailand', 'tagline' => 'Street food & river temples', 'places' => 428, 'accent' => 'amber'],
        ['name' => 'Paris', 'country' => 'France', 'tagline' => 'Timeless streets, iconic views', 'places' => 519, 'accent' => 'rose'],
    ];

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'featured_cities' => self::FEATURED_CITIES,
        ]);
    }
}
