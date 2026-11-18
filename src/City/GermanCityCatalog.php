<?php

declare(strict_types=1);

namespace App\City;

/**
 * In-memory catalog of the 24 largest German cities by population.
 *
 * This is the seed for Tripora's Germany-first launch. Once city
 * coverage grows beyond a hand-curated list, this should be replaced
 * by a database-backed repository behind the same two lookup methods.
 */
final class GermanCityCatalog
{
    /** @var GermanCity[] */
    private array $cities;

    public function __construct()
    {
        $this->cities = array_map(
            static fn (array $c) => new GermanCity(
                name: $c[0],
                slug: $c[1],
                state: $c[2],
                population: $c[3],
                tagline: $c[4],
                accent: $c[5],
                highlightIcon: $c[6],
                highlightLabel: $c[7],
                rating: $c[8],
                recommendations: $c[9],
                dailyBudgetFrom: $c[10],
                landmark: $c[11],
            ),
            self::data(),
        );
    }

    /**
     * @return GermanCity[] all cities, ordered by population (descending)
     */
    public function all(): array
    {
        return $this->cities;
    }

    /**
     * @return GermanCity[] the N most populous cities
     */
    public function popular(int $limit = 8): array
    {
        return array_slice($this->cities, 0, $limit);
    }

    public function findBySlug(string $slug): ?GermanCity
    {
        $slug = self::normalize($slug);

        foreach ($this->cities as $city) {
            if ($city->slug === $slug) {
                return $city;
            }
        }

        return null;
    }

    /**
     * Case- and umlaut-insensitive lookup by display name (e.g. "münchen",
     * "Muenchen" and "münchen " all resolve to the same city).
     */
    public function findByName(string $name): ?GermanCity
    {
        $needle = self::normalize($name);

        foreach ($this->cities as $city) {
            if ($city->slug === $needle || self::normalize($city->name) === $needle) {
                return $city;
            }
        }

        return null;
    }

    private static function normalize(string $value): string
    {
        $value = trim(mb_strtolower($value));
        $value = strtr($value, [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
        ]);

        return trim(preg_replace('/[^a-z0-9]+/', '-', $value) ?? '', '-');
    }

    /**
     * Columns: name, slug, state, population, tagline, accent,
     * highlightIcon, highlightLabel, rating, recommendations, dailyBudgetFrom,
     * landmark.
     *
     * The last three placeholders before `landmark` (rating, recommendations,
     * dailyBudgetFrom) are illustrative — see the class docblock on GermanCity.
     *
     * @return array<int, array{0: string, 1: string, 2: string, 3: int, 4: string, 5: string, 6: string, 7: string, 8: float, 9: int, 10: int, 11: string}>
     */
    private static function data(): array
    {
        return [
            ['Berlin', 'berlin', 'Berlin', 3_850_000, 'Kunst, Geschichte und Nächte ohne Ende', 'violet', 'moon', 'Nightlife', 4.8, 248, 35, 'Brandenburger Tor'],
            ['Hamburg', 'hamburg', 'Hamburg', 1_850_000, 'Hafenluft, Wind und Genussleben', 'teal', 'tree', 'Parks & Natur', 4.7, 189, 30, 'Elbphilharmonie und Speicherstadt'],
            ['München', 'muenchen', 'Bayern', 1_510_000, 'Tradition trifft Alpenblick', 'amber', 'columns', 'Museen & Kultur', 4.9, 231, 40, 'Frauenkirche und Marienplatz'],
            ['Köln', 'koeln', 'Nordrhein-Westfalen', 1_073_000, 'Rheinufer, Dom und Lebensfreude', 'coral', 'pin', 'Sehenswürdigkeiten', 4.6, 156, 28, 'Kölner Dom'],
            ['Frankfurt am Main', 'frankfurt-am-main', 'Hessen', 773_000, 'Skyline mit Sachsenhausen-Charme', 'indigo', 'route', 'Routenplanung', 4.5, 121, 32, 'Römerberg und Skyline'],
            ['Stuttgart', 'stuttgart', 'Baden-Württemberg', 626_000, 'Kessel voller Kultur und Wein', 'rose', 'fork', 'Restaurants', 4.6, 98, 27, 'Stuttgarter Schlossplatz'],
            ['Düsseldorf', 'duesseldorf', 'Nordrhein-Westfalen', 620_000, 'Mode, Kunst und Rheinpromenade', 'violet', 'cup', 'Cafés', 4.6, 104, 29, 'Rheinturm und Königsallee'],
            ['Leipzig', 'leipzig', 'Sachsen', 615_000, 'Kreativ, jung und musikalisch', 'teal', 'spark', 'Geheimtipps', 4.8, 142, 22, 'Völkerschlachtdenkmal'],
            ['Dortmund', 'dortmund', 'Nordrhein-Westfalen', 588_000, 'Ruhrpott-Herz mit Fußballseele', 'amber', 'moon', 'Nightlife', 4.5, 76, 24, 'Dortmunder U'],
            ['Essen', 'essen', 'Nordrhein-Westfalen', 579_000, 'Grüne Industriekultur im Ruhrgebiet', 'coral', 'tree', 'Parks & Natur', 4.5, 68, 21, 'Zeche Zollverein'],
            ['Bremen', 'bremen', 'Bremen', 567_000, 'Hanseatisch, herzlich, historisch', 'indigo', 'pin', 'Sehenswürdigkeiten', 4.7, 88, 23, 'Bremer Rathaus und Roland'],
            ['Dresden', 'dresden', 'Sachsen', 555_000, 'Barocke Schönheit an der Elbe', 'rose', 'columns', 'Museen & Kultur', 4.9, 176, 26, 'Frauenkirche und Elbufer'],
            ['Hannover', 'hannover', 'Niedersachsen', 535_000, 'Parks, Messen und norddeutsche Ruhe', 'violet', 'tree', 'Parks & Natur', 4.5, 71, 22, 'Neues Rathaus'],
            ['Nürnberg', 'nuernberg', 'Bayern', 516_000, 'Mittelalterliche Gassen, moderner Puls', 'teal', 'columns', 'Museen & Kultur', 4.8, 133, 25, 'Nürnberger Kaiserburg'],
            ['Duisburg', 'duisburg', 'Nordrhein-Westfalen', 495_000, 'Größter Binnenhafen, echtes Ruhrgebiet', 'amber', 'pin', 'Sehenswürdigkeiten', 4.4, 52, 20, 'Landschaftspark Duisburg-Nord'],
            ['Bochum', 'bochum', 'Nordrhein-Westfalen', 365_000, 'Bergbau-Erbe, Kumpel-Herz', 'coral', 'spark', 'Geheimtipps', 4.5, 61, 19, 'Jahrhunderthalle'],
            ['Wuppertal', 'wuppertal', 'Nordrhein-Westfalen', 355_000, 'Die Schwebebahn-Stadt', 'indigo', 'route', 'Routenplanung', 4.6, 58, 18, 'Wuppertaler Schwebebahn'],
            ['Bielefeld', 'bielefeld', 'Nordrhein-Westfalen', 334_000, 'Ostwestfalen mit Überraschung', 'rose', 'spark', 'Geheimtipps', 4.4, 47, 18, 'Sparrenburg'],
            ['Bonn', 'bonn', 'Nordrhein-Westfalen', 331_000, 'Beethovens Geburtsstadt am Rhein', 'violet', 'columns', 'Museen & Kultur', 4.7, 84, 24, 'Bonner Münster'],
            ['Münster', 'muenster', 'Nordrhein-Westfalen', 318_000, 'Fahrradstadt mit Altstadt-Charme', 'teal', 'cup', 'Cafés', 4.8, 96, 21, 'Prinzipalmarkt'],
            ['Mönchengladbach', 'moenchengladbach', 'Nordrhein-Westfalen', 261_000, 'Park- und Gartenstadt am Niederrhein', 'coral', 'tree', 'Parks & Natur', 4.4, 41, 19, 'Schloss Rheydt'],
            ['Gelsenkirchen', 'gelsenkirchen', 'Nordrhein-Westfalen', 260_000, 'Fußball, Zechen und Ruhrpott-Flair', 'amber', 'moon', 'Nightlife', 4.3, 38, 18, 'Veltins-Arena'],
            ['Aachen', 'aachen', 'Nordrhein-Westfalen', 249_000, 'Kaiserstadt mit Dom und Grenzcharme', 'violet', 'columns', 'Museen & Kultur', 4.7, 112, 25, 'Aachener Dom'],
            ['Braunschweig', 'braunschweig', 'Niedersachsen', 248_000, 'Löwenstadt zwischen Fachwerk und Forschung', 'teal', 'pin', 'Sehenswürdigkeiten', 4.5, 67, 22, 'Burgplatz mit Burglöwe'],
        ];
    }
}
