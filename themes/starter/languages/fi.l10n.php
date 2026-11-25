<?php
/**
 * Finnish translation of the Starter theme.
 *
 * WordPress (6.5+) reads this PHP array directly; no .po/.mo build needed.
 * Keys with a context are written as "context\4string".
 *
 * @package Starter
 */

return array(
	'domain'       => 'starter',
	'plural-forms' => 'nplurals=2; plural=(n != 1);',
	'language'     => 'fi',
	'messages'     => array(
		// theme.json.
		"Color name\4Base"                      => 'Pohja',
		"Color name\4Base alternative"          => 'Vaihtoehtoinen pohja',
		"Color name\4Contrast"                  => 'Kontrasti',
		"Color name\4Muted text"                => 'Hillitty teksti',
		"Color name\4Primary"                   => 'Pääväri',
		"Color name\4Text on primary"           => 'Teksti päävärin päällä',
		"Color name\4Accent"                    => 'Korostusväri',
		"Color name\4Text on accent"            => 'Teksti korostusvärin päällä',
		"Color name\4Border"                    => 'Reunaviiva',
		"Font family name\4Body"                => 'Leipäteksti',
		"Font family name\4Heading"             => 'Otsikot',
		"Font size name\4Small"                 => 'Pieni',
		"Font size name\4Body"                  => 'Leipäteksti',
		"Font size name\4Large"                 => 'Suuri',
		"Font size name\4Heading 2"             => 'Otsikko 2',
		"Font size name\4Heading 1"             => 'Otsikko 1',
		"Font size name\4Display"               => 'Iso otsikko',
		"Space size name\4Section"              => 'Osioiden väli',
		"Template part name\4Header"            => 'Ylätunniste',
		"Template part name\4Footer"            => 'Alatunniste',
		"Template part name\4Post meta"         => 'Artikkelin tiedot',
		"Custom template name\4Full-width sections" => 'Täysleveät osiot',

		// functions.php.
		'Card (4:3)'                            => 'Kortti (4:3)',
		'Eyebrow'                               => 'Yläotsake',
		'Card'                                  => 'Kortti',
		'Rounded corners'                       => 'Pyöristetyt kulmat',
		'Plain'                                 => 'Ilman luettelomerkkejä',
		'FAQ'                                   => 'UKK',
		'Sections'                              => 'Osiot',
		'Ready-made sections for this site.'    => 'Valmiit osiot tämän sivuston sivuille.',

		// Patterns.
		'Contact'                               => 'Yhteystiedot',
		'[Address]'                             => '[Osoite]',
		'[Phone]'                               => '[Puhelin]',
		'[Email]'                               => '[Sähköposti]',
		'Opening hours'                         => 'Aukioloajat',
		'[© Year Business name]'                => '[© Vuosi Yrityksen nimi]',
		'[Privacy notice]'                      => '[Tietosuojaseloste]',
		'News'                                  => 'Ajankohtaista',
		'Nothing was found. Try a different search word.' => 'Mitään ei löytynyt. Kokeile toista hakusanaa.',
		"search form label\4Search the site"    => 'Hae sivustolta',
		"search button\4Search"                 => 'Hae',
		'Page not found'                        => 'Sivua ei löytynyt',
		'The page may have moved or no longer exists. Try searching, or go back to the home page.' => 'Sivu on ehkä siirretty tai sitä ei enää ole. Kokeile hakua tai palaa etusivulle.',
		'Back to the home page'                 => 'Takaisin etusivulle',

		// Section pattern titles and descriptions (shown in the inserter).
		"Pattern title\4Hero"                   => 'Hero',
		"Pattern title\4Page header"            => 'Sivun otsikko',
		"Pattern title\4Services grid"          => 'Palvelut',
		"Pattern title\4About"                  => 'Meistä',
		"Pattern title\4Opening hours"          => 'Aukioloajat',
		"Pattern title\4Location"               => 'Sijainti',
		"Pattern title\4Team"                   => 'Tiimi',
		"Pattern title\4Gallery"                => 'Galleria',
		"Pattern title\4FAQ"                    => 'UKK',
		"Pattern title\4Call to action"         => 'Toimintakehote',
		"Pattern title\4Contact"                => 'Yhteystiedot ja lomake',
		"Pattern description\4Full-width image with the page's main heading (h1), a short intro and two buttons. Use once per page, at the top." => 'Täysleveä kuva, sivun pääotsikko (h1), lyhyt johdanto ja kaksi painiketta. Käytä kerran sivun alussa.',
		"Pattern description\4The page's main heading (h1) and a short intro. Use at the top of a \"Full-width sections\" page that has no hero." => 'Sivun pääotsikko (h1) ja lyhyt johdanto. Käytä "Täysleveät osiot" -sivun alussa, jos sivulla ei ole heroa.',
		"Pattern description\4Section heading and a grid of service cards. Duplicate or remove cards as needed; the grid adapts." => 'Osion otsikko ja palvelukortit. Monista tai poista kortteja tarpeen mukaan; ruudukko mukautuu.',
		"Pattern description\4Image beside a heading, text and a button. The image comes first on phones." => 'Kuva otsikon, tekstin ja painikkeen vieressä. Puhelimessa kuva näkyy ensin.',
		"Pattern description\4Opening hours from Settings → Business details, with room for exceptions such as holidays." => 'Aukioloajat kohdasta Asetukset → Yrityksen tiedot sekä tila poikkeusaukioloajoille.',
		"Pattern description\4Address and directions with a link that opens the map. A link instead of an embedded map: no cookies, no slow third-party scripts." => 'Osoite, ajo-ohjeet ja linkki karttaan. Linkki upotetun kartan sijaan: ei evästeitä eikä hitaita ulkopuolisia skriptejä.',
		"Pattern description\4Team members with photo, name and role. Only real people with the owner's permission, and their own photos." => 'Tiimin jäsenet kuvan, nimen ja tehtävän kanssa. Vain oikeita henkilöitä heidän luvallaan ja heidän omilla kuvillaan.',
		"Pattern description\4Section heading and an image gallery. Replace the placeholders with the client's own photos (Gallery → Add)." => 'Osion otsikko ja kuvagalleria. Korvaa paikkamerkit omilla kuvilla.',
		"Pattern description\4Frequently asked questions as expandable Details blocks (FAQ style). Works with the keyboard and without JavaScript." => 'Usein kysytyt kysymykset avautuvina lohkoina. Toimii näppäimistöllä ja ilman JavaScriptiä.',
		"Pattern description\4Full-width band in the primary colour with a heading, a sentence and one button." => 'Täysleveä pääväriä oleva kaista, jossa otsikko, lause ja yksi painike.',
		"Pattern description\4Contact details and opening hours from Settings → Business details, beside the contact form." => 'Yhteystiedot ja aukioloajat kohdasta Asetukset → Yrityksen tiedot sekä yhteydenottolomake.',
	),
);
