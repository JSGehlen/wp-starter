<?php
/**
 * LocalBusiness structured data (JSON-LD) on the front page, built from
 * Settings → Business details. Only fields that have a value are printed;
 * nothing is invented.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The structured data as an array (also handy for testing).
 *
 * @return array
 */
function starter_core_local_business_data() {
	$b    = starter_core_business();
	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => $b['type'],
		'@id'      => home_url( '/#localbusiness' ),
		'name'     => starter_core_get( 'name' ),
		'url'      => home_url( '/' ),
	);

	$description = get_bloginfo( 'description' );
	if ( '' !== $description ) {
		$data['description'] = $description;
	}
	if ( '' !== $b['phone'] ) {
		$data['telephone'] = $b['phone'];
	}
	if ( is_email( $b['email'] ) ) {
		$data['email'] = $b['email'];
	}

	if ( '' !== $b['street'] || '' !== $b['city'] ) {
		$data['address'] = array_filter(
			array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $b['street'],
				'postalCode'      => $b['postal_code'],
				'addressLocality' => $b['city'],
				'addressCountry'  => $b['country'],
			)
		);
	}

	if ( '' !== $b['latitude'] && '' !== $b['longitude'] ) {
		$data['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) $b['latitude'],
			'longitude' => (float) $b['longitude'],
		);
	}

	$map = starter_core_get( 'map_url' );
	if ( '' !== $map ) {
		$data['hasMap'] = $map;
	}

	// One specification per day with hours; closed days are simply not listed.
	$days  = starter_core_days();
	$specs = array();
	foreach ( $b['hours'] as $day => $h ) {
		if ( empty( $h['closed'] ) && '' !== $h['opens'] && '' !== $h['closes'] ) {
			$specs[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => 'https://schema.org/' . $days[ $day ]['schema'],
				'opens'     => $h['opens'],
				'closes'    => $h['closes'],
			);
		}
	}
	if ( $specs ) {
		$data['openingHoursSpecification'] = $specs;
	}

	$logo_id = (int) get_theme_mod( 'custom_logo' );
	$image   = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : get_site_icon_url( 512 );
	if ( $image ) {
		$data['image'] = $image;
	}

	if ( $b['same_as'] ) {
		$data['sameAs'] = $b['same_as'];
	}

	return apply_filters( 'starter_core_local_business_data', $data );
}

add_action(
	'wp_head',
	static function () {
		if ( ! is_front_page() ) {
			return;
		}

		printf(
			"<script type=\"application/ld+json\">%s</script>\n",
			wp_json_encode( starter_core_local_business_data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG )
		);
	}
);
