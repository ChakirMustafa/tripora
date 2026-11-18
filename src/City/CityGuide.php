<?php

declare(strict_types=1);

namespace App\City;

/**
 * Curated, editorially-written highlights for each destination page.
 *
 * Unlike the illustrative rating/budget placeholders on GermanCity, the
 * entries below point at well-known landmarks and districts and are meant
 * to give a first, honest overview of what a city is known for rather than
 * an exhaustive directory.
 */
final class CityGuide
{
    private const CATEGORIES = [
        'pin' => 'Sehenswürdigkeiten',
        'fork' => 'Restaurants',
        'cup' => 'Cafés',
        'columns' => 'Museen & Kultur',
        'tree' => 'Parks & Natur',
        'moon' => 'Nightlife',
        'spark' => 'Geheimtipps',
        'route' => 'Routenplanung',
    ];

    /**
     * @return list<array{icon: string, title: string, blurb: string}>
     */
    public function highlights(string $slug): array
    {
        return self::DATA[$slug] ?? [];
    }

    public function categoryLabel(string $icon): string
    {
        return self::CATEGORIES[$icon] ?? $icon;
    }

    /**
     * The subset of categories actually used by the given highlights,
     * ordered like the canonical category list.
     *
     * @param list<array{icon: string, title: string, blurb: string}> $highlights
     *
     * @return list<array{icon: string, label: string}>
     */
    public function categoriesFor(array $highlights): array
    {
        $used = array_column($highlights, 'icon');

        $categories = [];
        foreach (self::CATEGORIES as $icon => $label) {
            if (in_array($icon, $used, true)) {
                $categories[] = ['icon' => $icon, 'label' => $label];
            }
        }

        return $categories;
    }

    /**
     * @var array<string, list<array{icon: string, title: string, blurb: string}>>
     */
    private const DATA = [
        'berlin' => [
            ['icon' => 'pin', 'title' => 'Brandenburger Tor', 'blurb' => 'Das Wahrzeichen Berlins an der Grenze zwischen Mitte und Tiergarten.'],
            ['icon' => 'columns', 'title' => 'Museumsinsel', 'blurb' => 'UNESCO-Welterbe mit fünf Häusern rund um den Lustgarten.'],
            ['icon' => 'tree', 'title' => 'Tiergarten', 'blurb' => 'Berlins grüne Lunge mit rund 210 Hektar Parkfläche.'],
            ['icon' => 'moon', 'title' => 'Kreuzberg & Friedrichshain', 'blurb' => 'Bars, Clubs und Streetfood rund um die Spree.'],
        ],
        'hamburg' => [
            ['icon' => 'pin', 'title' => 'Elbphilharmonie', 'blurb' => 'Konzerthaus mit öffentlicher Aussichtsplattform über dem Hafen.'],
            ['icon' => 'pin', 'title' => 'Speicherstadt', 'blurb' => 'Historische Lagerhäuser auf Eichenpfählen, UNESCO-Welterbe.'],
            ['icon' => 'tree', 'title' => 'Planten un Blomen', 'blurb' => 'Park mit Wasserlichtspielen mitten in der Stadt.'],
            ['icon' => 'fork', 'title' => 'Fischmarkt', 'blurb' => 'Legendärer Markt am Sonntagmorgen in Altona.'],
        ],
        'muenchen' => [
            ['icon' => 'pin', 'title' => 'Marienplatz', 'blurb' => 'Zentraler Platz mit Neuem Rathaus und Glockenspiel.'],
            ['icon' => 'tree', 'title' => 'Englischer Garten', 'blurb' => 'Einer der größten innerstädtischen Parks der Welt.'],
            ['icon' => 'columns', 'title' => 'Deutsches Museum', 'blurb' => 'Großes Technikmuseum auf der Museumsinsel in der Isar.'],
            ['icon' => 'fork', 'title' => 'Viktualienmarkt', 'blurb' => 'Markt mit bayerischen Spezialitäten im Zentrum.'],
        ],
        'koeln' => [
            ['icon' => 'pin', 'title' => 'Kölner Dom', 'blurb' => 'Gotische Kathedrale und UNESCO-Welterbe am Hauptbahnhof.'],
            ['icon' => 'pin', 'title' => 'Hohenzollernbrücke', 'blurb' => 'Rheinbrücke mit tausenden Liebesschlössern.'],
            ['icon' => 'columns', 'title' => 'Museum Ludwig', 'blurb' => 'Moderne Kunst und Pop-Art direkt am Dom.'],
            ['icon' => 'fork', 'title' => 'Brauhäuser der Altstadt', 'blurb' => 'Kölsch und rheinische Küche in traditionellen Brauhäusern.'],
        ],
        'frankfurt-am-main' => [
            ['icon' => 'pin', 'title' => 'Römerberg', 'blurb' => 'Historischer Marktplatz mit Fachwerkhäusern.'],
            ['icon' => 'pin', 'title' => 'Main Tower', 'blurb' => 'Aussichtsterrasse über die Skyline der Stadt.'],
            ['icon' => 'columns', 'title' => 'Städel Museum', 'blurb' => 'Bedeutende Kunstsammlung vom Mittelalter bis zur Gegenwart.'],
            ['icon' => 'tree', 'title' => 'Palmengarten', 'blurb' => 'Botanischer Garten mit großem Palmenhaus.'],
        ],
        'stuttgart' => [
            ['icon' => 'columns', 'title' => 'Mercedes-Benz Museum', 'blurb' => 'Automobilgeschichte auf neun Ebenen.'],
            ['icon' => 'columns', 'title' => 'Porsche Museum', 'blurb' => 'Sportwagengeschichte im Stadtteil Zuffenhausen.'],
            ['icon' => 'pin', 'title' => 'Schlossplatz', 'blurb' => 'Barocke Mitte der Stadt mit Neuem Schloss.'],
            ['icon' => 'tree', 'title' => 'Wilhelma', 'blurb' => 'Zoologisch-botanischer Garten im Neckartal.'],
        ],
        'duesseldorf' => [
            ['icon' => 'pin', 'title' => 'Königsallee', 'blurb' => 'Luxusmeile entlang des Stadtgrabens.'],
            ['icon' => 'pin', 'title' => 'MedienHafen', 'blurb' => 'Moderne Architektur am Rhein mit Bauten von Gehry und Co.'],
            ['icon' => 'columns', 'title' => 'Kunstsammlung K20', 'blurb' => 'Kunst des 20. Jahrhunderts am Grabbeplatz.'],
            ['icon' => 'cup', 'title' => 'Altstadt', 'blurb' => 'Die „längste Theke der Welt“ mit zahlreichen Brauhäusern.'],
        ],
        'leipzig' => [
            ['icon' => 'pin', 'title' => 'Völkerschlachtdenkmal', 'blurb' => 'Monumentales Denkmal zur Völkerschlacht von 1813.'],
            ['icon' => 'columns', 'title' => 'Baumwollspinnerei', 'blurb' => 'Kunstzentrum in einer ehemaligen Baumwollspinnerei.'],
            ['icon' => 'pin', 'title' => 'Thomaskirche', 'blurb' => 'Wirkungsstätte von Johann Sebastian Bach.'],
            ['icon' => 'tree', 'title' => 'Clara-Zetkin-Park', 'blurb' => 'Große Parkanlage entlang der Pleiße.'],
        ],
        'dortmund' => [
            ['icon' => 'pin', 'title' => 'Signal Iduna Park', 'blurb' => 'Heimstadion von Borussia Dortmund.'],
            ['icon' => 'tree', 'title' => 'Westfalenpark', 'blurb' => 'Park mit dem Aussichtsturm Florian.'],
            ['icon' => 'columns', 'title' => 'Museum Ostwall', 'blurb' => 'Kunst und Kultur des 20. Jahrhunderts.'],
            ['icon' => 'pin', 'title' => 'Phoenixsee', 'blurb' => 'Freizeitsee auf einem ehemaligen Stahlwerksgelände.'],
        ],
        'essen' => [
            ['icon' => 'pin', 'title' => 'Zeche Zollverein', 'blurb' => 'Industriedenkmal und UNESCO-Welterbe.'],
            ['icon' => 'columns', 'title' => 'Museum Folkwang', 'blurb' => 'Kunstsammlung des 19. und 20. Jahrhunderts.'],
            ['icon' => 'tree', 'title' => 'Grugapark', 'blurb' => 'Großer Botanischer Garten mit Gartenkunst.'],
            ['icon' => 'pin', 'title' => 'Villa Hügel', 'blurb' => 'Ehemalige Residenz der Industriellenfamilie Krupp.'],
        ],
        'bremen' => [
            ['icon' => 'pin', 'title' => 'Rathaus & Roland', 'blurb' => 'UNESCO-Welterbe am Marktplatz.'],
            ['icon' => 'pin', 'title' => 'Schnoorviertel', 'blurb' => 'Enge Gassen mit historischen Häusern.'],
            ['icon' => 'pin', 'title' => 'Böttcherstraße', 'blurb' => 'Kunstvolle Straße mit Museen und Handwerk.'],
            ['icon' => 'tree', 'title' => 'Bürgerpark', 'blurb' => 'Weitläufiger Park mit Botanika.'],
        ],
        'dresden' => [
            ['icon' => 'pin', 'title' => 'Frauenkirche', 'blurb' => 'Barocke Kirche, die nach 1945 wiederaufgebaut wurde.'],
            ['icon' => 'columns', 'title' => 'Zwinger', 'blurb' => 'Barockes Ensemble mit mehreren Museen.'],
            ['icon' => 'columns', 'title' => 'Semperoper', 'blurb' => 'Berühmtes Opernhaus am Elbufer.'],
            ['icon' => 'tree', 'title' => 'Großer Garten', 'blurb' => 'Barocker Park mit Sommerpalais und Palaisteich.'],
        ],
        'hannover' => [
            ['icon' => 'tree', 'title' => 'Herrenhäuser Gärten', 'blurb' => 'Barocke Gartenanlage mit Großem Garten.'],
            ['icon' => 'tree', 'title' => 'Maschsee', 'blurb' => 'Künstlich angelegter See mitten in der Stadt.'],
            ['icon' => 'pin', 'title' => 'Neues Rathaus', 'blurb' => 'Rathaus mit Kuppel und Panoramaaufzug.'],
            ['icon' => 'columns', 'title' => 'Sprengel Museum', 'blurb' => 'Museum für moderne Kunst am Maschsee.'],
        ],
        'nuernberg' => [
            ['icon' => 'pin', 'title' => 'Kaiserburg', 'blurb' => 'Mittelalterliche Burg hoch über der Altstadt.'],
            ['icon' => 'pin', 'title' => 'Hauptmarkt', 'blurb' => 'Marktplatz mit Schönem Brunnen und Lebkuchenständen.'],
            ['icon' => 'columns', 'title' => 'Germanisches Nationalmuseum', 'blurb' => 'Großes kulturgeschichtliches Museum.'],
            ['icon' => 'spark', 'title' => 'Dürerhaus', 'blurb' => 'Wohnhaus des Malers Albrecht Dürer am Tiergärtnertor.'],
        ],
        'duisburg' => [
            ['icon' => 'pin', 'title' => 'Landschaftspark Duisburg-Nord', 'blurb' => 'Umgenutztes Hüttenwerk mit abendlicher Lichtinstallation.'],
            ['icon' => 'pin', 'title' => 'Innenhafen', 'blurb' => 'Hafenareal mit Museen, Promenade und Gastronomie.'],
            ['icon' => 'columns', 'title' => 'Museum Küppersmühle', 'blurb' => 'Kunst in einem ehemaligen Getreidespeicher.'],
            ['icon' => 'tree', 'title' => 'Zoo Duisburg', 'blurb' => 'Tierpark mit Delfinarium am Kaiserberg.'],
        ],
        'bochum' => [
            ['icon' => 'columns', 'title' => 'Deutsches Bergbau-Museum', 'blurb' => 'Eines der größten Bergbaumuseen der Welt.'],
            ['icon' => 'moon', 'title' => 'Bermuda3Eck', 'blurb' => 'Ausgehviertel mit Bars, Kneipen und Clubs.'],
            ['icon' => 'pin', 'title' => 'Jahrhunderthalle', 'blurb' => 'Industriedenkmal und Veranstaltungsort im Westpark.'],
            ['icon' => 'tree', 'title' => 'Stadtpark Bochum', 'blurb' => 'Parkanlage mit angrenzendem Tierpark.'],
        ],
        'wuppertal' => [
            ['icon' => 'pin', 'title' => 'Schwebebahn', 'blurb' => 'Älteste Einschienenhängebahn der Welt.'],
            ['icon' => 'columns', 'title' => 'Von der Heydt-Museum', 'blurb' => 'Kunstsammlung im Zentrum von Elberfeld.'],
            ['icon' => 'route', 'title' => 'Nordbahntrasse', 'blurb' => 'Rad- und Fußweg auf einer stillgelegten Bahnstrecke.'],
            ['icon' => 'tree', 'title' => 'Botanischer Garten', 'blurb' => 'Garten mit Glashäusern nahe dem Grünen Zoo.'],
        ],
        'bielefeld' => [
            ['icon' => 'pin', 'title' => 'Sparrenburg', 'blurb' => 'Mittelalterliche Burg mit Blick über die Stadt.'],
            ['icon' => 'pin', 'title' => 'Altstadt', 'blurb' => 'Fußgängerzone mit historischem Rathaus und Leineweberdenkmal.'],
            ['icon' => 'columns', 'title' => 'Kunsthalle Bielefeld', 'blurb' => 'Museum für moderne Kunst im Nordpark.'],
            ['icon' => 'tree', 'title' => 'Tierpark Olderdissen', 'blurb' => 'Heimattierpark mit einheimischen Tierarten, Eintritt frei.'],
        ],
        'bonn' => [
            ['icon' => 'pin', 'title' => 'Beethoven-Haus', 'blurb' => 'Geburtshaus des Komponisten in der Altstadt.'],
            ['icon' => 'pin', 'title' => 'Rheinpromenade', 'blurb' => 'Uferweg mit Blick auf das Siebengebirge.'],
            ['icon' => 'columns', 'title' => 'Museumsmeile', 'blurb' => 'Museen wie das Museum Koenig entlang der B9.'],
            ['icon' => 'tree', 'title' => 'Poppelsdorfer Schloss', 'blurb' => 'Barockes Schloss mit Botanischem Garten.'],
        ],
        'muenster' => [
            ['icon' => 'pin', 'title' => 'Prinzipalmarkt', 'blurb' => 'Historischer Marktplatz mit charakteristischen Giebelhäusern.'],
            ['icon' => 'pin', 'title' => 'St.-Paulus-Dom', 'blurb' => 'Bischofskirche im Zentrum der Altstadt.'],
            ['icon' => 'tree', 'title' => 'Aasee', 'blurb' => 'See mit Promenade, Segelclub und Tretbooten.'],
            ['icon' => 'columns', 'title' => 'LWL-Museum für Kunst und Kultur', 'blurb' => 'Kunst- und Kulturgeschichte Westfalens.'],
        ],
        'moenchengladbach' => [
            ['icon' => 'pin', 'title' => 'Borussia-Park', 'blurb' => 'Stadion von Borussia Mönchengladbach.'],
            ['icon' => 'columns', 'title' => 'Museum Abteiberg', 'blurb' => 'Postmoderner Museumsbau von Hans Hollein.'],
            ['icon' => 'pin', 'title' => 'Schloss Rheydt', 'blurb' => 'Renaissanceschloss mit Museum im Stadtteil Rheydt.'],
            ['icon' => 'tree', 'title' => 'Bunter Garten', 'blurb' => 'Parkanlage mit angeschlossenem Botanischem Garten.'],
        ],
        'gelsenkirchen' => [
            ['icon' => 'pin', 'title' => 'Veltins-Arena', 'blurb' => 'Stadion des FC Schalke 04 in Schalke.'],
            ['icon' => 'tree', 'title' => 'Nordsternpark', 'blurb' => 'Park auf einem ehemaligen Zechengelände.'],
            ['icon' => 'pin', 'title' => 'Zoom Erlebniswelt', 'blurb' => 'Tierpark mit drei großzügigen Erlebniswelten.'],
            ['icon' => 'columns', 'title' => 'Musiktheater im Revier', 'blurb' => 'Preisgekrönter Theaterbau der 1950er Jahre.'],
        ],
        'aachen' => [
            ['icon' => 'pin', 'title' => 'Aachener Dom', 'blurb' => 'Kaiserdom und UNESCO-Welterbe im Zentrum.'],
            ['icon' => 'pin', 'title' => 'Rathaus', 'blurb' => 'Gotisches Rathaus im ehemaligen Bau Karls des Großen.'],
            ['icon' => 'tree', 'title' => 'Elisenbrunnen', 'blurb' => 'Klassizistische Brunnenhalle mit Thermalwasser.'],
            ['icon' => 'fork', 'title' => 'Printen-Bäckereien', 'blurb' => 'Traditionelle Aachener Printen direkt vor Ort probieren.'],
        ],
        'braunschweig' => [
            ['icon' => 'pin', 'title' => 'Burgplatz & Löwe', 'blurb' => 'Platz mit dem Braunschweiger Löwen und Burg Dankwarderode.'],
            ['icon' => 'pin', 'title' => 'Altstadtmarkt', 'blurb' => 'Mittelalterlicher Marktplatz mit Altstadt-Rathaus.'],
            ['icon' => 'columns', 'title' => 'Herzog Anton Ulrich-Museum', 'blurb' => 'Eines der ältesten Kunstmuseen Europas.'],
            ['icon' => 'tree', 'title' => 'Okerufer', 'blurb' => 'Grüner Spazierweg entlang der Oker.'],
        ],
    ];
}
