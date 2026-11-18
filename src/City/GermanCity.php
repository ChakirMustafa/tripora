<?php

declare(strict_types=1);

namespace App\City;

/**
 * A single German city featured on the platform.
 *
 * Immutable value object — population figures are approximate
 * (rounded, based on official 2023/2024 city statistics) and are
 * meant for display purposes, not analytical precision.
 *
 * $rating / $recommendations / $dailyBudgetFrom are illustrative
 * placeholders for a planned recommendations/itinerary-budget feature —
 * they are not derived from real user data yet. They're rendered with an
 * explicit "Vorschau" (preview) label wherever they're shown to visitors.
 */
final readonly class GermanCity
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $state,
        public int $population,
        public string $tagline,
        public string $accent,
        public string $highlightIcon,
        public string $highlightLabel,
        public float $rating,
        public int $recommendations,
        public int $dailyBudgetFrom,
        public string $landmark,
    ) {
    }

    public function populationLabel(): string
    {
        return number_format($this->population, 0, ',', '.').' Einwohner';
    }

    public function ratingLabel(): string
    {
        return number_format($this->rating, 1, ',', '.');
    }

    /**
     * Path (relative to the assets root) of the photo representing this
     * city — its landmark. Used as the card thumbnail.
     */
    public function imagePath(): string
    {
        return 'images/cities/'.$this->slug.'.jpg';
    }

    /**
     * Plain-array representation used to feed the client-side
     * autocomplete (see assets/controllers/city_search_controller.js).
     *
     * @return array{name: string, slug: string, state: string, population: int}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'state' => $this->state,
            'population' => $this->population,
        ];
    }
}
