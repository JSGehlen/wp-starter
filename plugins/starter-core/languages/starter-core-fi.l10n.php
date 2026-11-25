<?php
/**
 * Finnish translation of Starter Core.
 *
 * WordPress (6.5+) reads this PHP array directly; no .po/.mo build needed.
 * Keys with a context are written as "context\4string"; plural forms as
 * "singular\0plural" => "yksikkö\0monikko".
 *
 * @package StarterCore
 */

return array(
	'domain'       => 'starter-core',
	'plural-forms' => 'nplurals=2; plural=(n != 1);',
	'language'     => 'fi',
	'messages'     => array(
		// Plugin header (Plugins screen).
		'Site functionality that must not depend on the theme: business details, contact form, opening hours, SEO fields, structured data and the preview notice.' => 'Sivuston toiminnot, jotka eivät saa riippua teemasta: yrityksen tiedot, yhteydenottolomake, aukioloajat, hakukonekentät, rakenteinen data ja esikatseluilmoitus.',

		// Block metadata (block.json).
		"block title\4Opening hours"   => 'Aukioloajat',
		"block title\4Contact form"    => 'Yhteydenottolomake',
		"block description\4Opening hours from Settings → Business details, grouped by days with the same hours." => 'Aukioloajat kohdasta Asetukset → Yrityksen tiedot. Päivät, joilla on samat ajat, yhdistetään.',
		"block description\4Name, email, optional phone and message, sent by email to the address in Settings → Business details. Works without JavaScript." => 'Nimi, sähköposti, vapaaehtoinen puhelinnumero ja viesti. Lähetetään sähköpostilla kohdassa Asetukset → Yrityksen tiedot annettuun osoitteeseen. Toimii ilman JavaScriptiä.',

		// Settings page.
		'Business details'             => 'Yrityksen tiedot',
		'These details appear in the footer, on the contact and location sections, in the opening hours and in the information shown to search engines. Change them here and they update everywhere.' => 'Nämä tiedot näkyvät alatunnisteessa, yhteystieto- ja sijaintiosioissa, aukioloajoissa sekä hakukoneille annettavissa tiedoissa. Kun muutat ne tässä, ne päivittyvät kaikkialle.',
		'Business'                     => 'Yritys',
		'Business name'                => 'Yrityksen nimi',
		'Leave empty to use the site title.' => 'Jätä tyhjäksi, niin käytetään sivuston otsikkoa.',
		'Business type'                => 'Toimiala',
		'Tells search engines what kind of business this is.' => 'Kertoo hakukoneille, millainen yritys on kyseessä.',
		'Local business (general)'     => 'Paikallinen yritys (yleinen)',
		'Store'                        => 'Kauppa',
		'Restaurant'                   => 'Ravintola',
		'Café'                         => 'Kahvila',
		'Bakery'                       => 'Leipomo',
		'Hair salon'                   => 'Kampaamo',
		'Beauty salon'                 => 'Kauneushoitola',
		'Health and beauty'            => 'Terveys ja hyvinvointi',
		'Medical or therapy practice'  => 'Vastaanotto tai terapia',
		'Dentist'                      => 'Hammaslääkäri',
		'Professional service'         => 'Asiantuntijapalvelu',
		'Home and construction'        => 'Rakentaminen ja kodin palvelut',
		'Car repair'                   => 'Autokorjaamo',
		'Sports and fitness'           => 'Urheilu ja liikunta',
		'Accommodation'                => 'Majoitus',
		'Farm'                         => 'Maatila',
		'Address and contact details'  => 'Osoite ja yhteystiedot',
		'Street address'               => 'Katuosoite',
		'Postal code'                  => 'Postinumero',
		'City'                         => 'Postitoimipaikka',
		'Country code'                 => 'Maakoodi',
		'Two letters, e.g. FI.'        => 'Kaksi kirjainta, esim. FI.',
		'Phone'                        => 'Puhelin',
		'Email'                        => 'Sähköposti',
		'Map link'                     => 'Karttalinkki',
		'Optional. Leave empty to link to Google Maps with the address above.' => 'Vapaaehtoinen. Jos jätät tyhjäksi, linkki avaa yllä olevan osoitteen Google Mapsissa.',
		'Latitude'                     => 'Leveysaste',
		'Longitude'                    => 'Pituusaste',
		'Optional, for search engines. E.g. 60.1699' => 'Vapaaehtoinen, hakukoneita varten. Esim. 60.1699',
		'Optional. E.g. 24.9384'       => 'Vapaaehtoinen. Esim. 24.9384',
		'Social media profiles'        => 'Some-profiilit',
		'One address per line, e.g. https://www.facebook.com/… For search engines; the icons in the footer are edited in the site editor.' => 'Yksi osoite riviä kohden, esim. https://www.facebook.com/… Hakukoneita varten; alatunnisteen kuvakkeita muokataan sivuston muokkaimessa.',
		'Opening hours'                => 'Aukioloajat',
		'Leave a day empty if it should not be shown. Exceptions such as public holidays are written on the page itself.' => 'Jätä päivä tyhjäksi, jos sitä ei näytetä. Poikkeukset, kuten arkipyhät, kirjoitetaan itse sivulle.',
		'Opens'                        => 'Avautuu',
		'Closes'                       => 'Sulkeutuu',
		'Closed'                       => 'Suljettu',
		'Contact form'                 => 'Yhteydenottolomake',
		'Send form messages to'        => 'Lomakkeen viestit osoitteeseen',
		'Leave empty to use the email address above.' => 'Jätä tyhjäksi, niin käytetään yllä olevaa sähköpostiosoitetta.',

		// Opening hours block.
		'No opening hours yet. Add them under Settings → Business details.' => 'Aukioloaikoja ei ole vielä annettu. Lisää ne kohdassa Asetukset → Yrityksen tiedot.',

		// Contact form.
		'Name'                         => 'Nimi',
		'Phone (optional)'             => 'Puhelin (vapaaehtoinen)',
		'Message'                      => 'Viesti',
		'Required field'               => 'Pakollinen tieto',
		'Send'                         => 'Lähetä',
		'We use your details only to reply to your message.' => 'Käytämme tietojasi vain viestiisi vastaamiseen.',
		'Privacy notice'               => 'Tietosuojaseloste',
		'Thank you, your message has been sent.' => 'Kiitos, viestisi on lähetetty.',
		'We will reply as soon as we can.' => 'Vastaamme mahdollisimman pian.',
		"Please check %d field.\0Please check %d fields." => "Tarkista %d kenttä.\0Tarkista %d kenttää.",
		'Please enter your name.'      => 'Kirjoita nimesi.',
		'Please enter your email address.' => 'Kirjoita sähköpostiosoitteesi.',
		'Please check the email address, e.g. name@example.com.' => 'Tarkista sähköpostiosoite, esim. nimi@esimerkki.fi.',
		'Please check the phone number.' => 'Tarkista puhelinnumero.',
		'Please write a message.'      => 'Kirjoita viesti.',
		'The form had expired. Please check your message and send it again.' => 'Lomake oli vanhentunut. Tarkista viestisi ja lähetä se uudelleen.',
		'Too many messages in a short time. Please try again in a few minutes.' => 'Liian monta viestiä lyhyessä ajassa. Yritä uudelleen muutaman minuutin kuluttua.',
		'Sorry, the message could not be sent. Please try again later, or contact us at %s.' => 'Valitettavasti viestiä ei voitu lähettää. Yritä myöhemmin uudelleen tai ota yhteyttä: %s.',
		'Sorry, the message could not be sent. Please try again later.' => 'Valitettavasti viestiä ei voitu lähettää. Yritä myöhemmin uudelleen.',
		'Message from the website: %s' => 'Yhteydenotto verkkosivuilta: %s',
		'Sent from the contact form on: %s' => 'Lähetetty yhteydenottolomakkeella sivulta: %s',
		'Name: %s'                     => 'Nimi: %s',
		'Email: %s'                    => 'Sähköposti: %s',
		'Phone: %s'                    => 'Puhelin: %s',
		'Message:'                     => 'Viesti:',
		'Reply to this email to answer the sender directly.' => 'Vastaa tähän sähköpostiin, niin vastaus menee suoraan lähettäjälle.',

		// Editor UI (passed to scripts as window.starterCoreL10n).
		'Show phone number field'      => 'Näytä puhelinnumerokenttä',
		'Button text'                  => 'Painikkeen teksti',
		'Leave empty for “Send”.'      => 'Jätä tyhjäksi, niin tekstinä on ”Lähetä”.',
		'Form'                         => 'Lomake',
		'Messages are sent to the address in Settings → Business details.' => 'Viestit lähetetään kohdassa Asetukset → Yrityksen tiedot annettuun osoitteeseen.',
		'Day names'                    => 'Päivien nimet',
		'Short (Mon–Fri)'              => 'Lyhyet (ma–pe)',
		'Full (Monday–Friday)'         => 'Pitkät (maanantai–perjantai)',
		'Search engines'               => 'Hakukoneet',
		'Title in search results'      => 'Otsikko hakutuloksissa',
		'Leave empty to use the page title and site name. About 50–60 characters.' => 'Jätä tyhjäksi, niin käytetään sivun otsikkoa ja sivuston nimeä. Noin 50–60 merkkiä.',
		'Description in search results' => 'Kuvaus hakutuloksissa',
		'One or two sentences about this page. About 120–155 characters.' => 'Yksi tai kaksi lausetta tästä sivusta. Noin 120–155 merkkiä.',
		'%d characters'                => '%d merkkiä',
	),
);
