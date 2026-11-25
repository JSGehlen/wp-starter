<?php
/**
 * Business details: the single source for name, address, contact details and
 * opening hours. Edited under Settings → Business details; read by the
 * bindings, the opening-hours block, the contact form and the structured data.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const STARTER_CORE_OPTION = 'starter_core_business';

/**
 * Weekday keys in display order, mapped to schema.org day names and to
 * WP_Locale's weekday index (0 = Sunday).
 *
 * @return array<string, array{schema: string, index: int}>
 */
function starter_core_days() {
	return array(
		'mo' => array(
			'schema' => 'Monday',
			'index'  => 1,
		),
		'tu' => array(
			'schema' => 'Tuesday',
			'index'  => 2,
		),
		'we' => array(
			'schema' => 'Wednesday',
			'index'  => 3,
		),
		'th' => array(
			'schema' => 'Thursday',
			'index'  => 4,
		),
		'fr' => array(
			'schema' => 'Friday',
			'index'  => 5,
		),
		'sa' => array(
			'schema' => 'Saturday',
			'index'  => 6,
		),
		'su' => array(
			'schema' => 'Sunday',
			'index'  => 0,
		),
	);
}

/**
 * Empty settings, also used as the shape for sanitising.
 *
 * @return array
 */
function starter_core_business_defaults() {
	$hours = array();
	foreach ( array_keys( starter_core_days() ) as $day ) {
		$hours[ $day ] = array(
			'closed' => false,
			'opens'  => '',
			'closes' => '',
		);
	}

	return array(
		'name'        => '',
		'type'        => 'LocalBusiness',
		'street'      => '',
		'postal_code' => '',
		'city'        => '',
		'country'     => 'FI',
		'phone'       => '',
		'email'       => '',
		'latitude'    => '',
		'longitude'   => '',
		'map_url'     => '',
		'same_as'     => array(),
		'hours'       => $hours,
		'form_to'     => '',
	);
}

/**
 * Saved settings merged over the defaults.
 *
 * @return array
 */
function starter_core_business() {
	$saved    = get_option( STARTER_CORE_OPTION, array() );
	$defaults = starter_core_business_defaults();
	$data     = array_merge( $defaults, is_array( $saved ) ? $saved : array() );

	$data['hours'] = array_merge( $defaults['hours'], is_array( $data['hours'] ) ? $data['hours'] : array() );

	return $data;
}

/**
 * One value, with sensible fallbacks.
 *
 * @param string $key Setting key.
 * @return mixed
 */
function starter_core_get( $key ) {
	$data = starter_core_business();

	switch ( $key ) {
		case 'name':
			return '' !== $data['name'] ? $data['name'] : get_bloginfo( 'name' );

		case 'form_to':
			if ( is_email( $data['form_to'] ) ) {
				return $data['form_to'];
			}
			return is_email( $data['email'] ) ? $data['email'] : get_option( 'admin_email' );

		case 'map_url':
			if ( '' !== $data['map_url'] ) {
				return $data['map_url'];
			}
			$address = starter_core_address_line();
			// Google Maps search link (documented "Maps URLs" format, no API key, no embed).
			return '' !== $address ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( starter_core_get( 'name' ) . ', ' . $address ) : '';

		default:
			return $data[ $key ] ?? '';
	}
}

/**
 * Address on one line: "Street 1, 00100 City".
 *
 * @return string
 */
function starter_core_address_line() {
	$data  = starter_core_business();
	$place = trim( $data['postal_code'] . ' ' . $data['city'] );
	return implode( ', ', array_filter( array( $data['street'], $place ) ) );
}

/**
 * Phone number for a tel: link: digits and a leading +, nothing else.
 *
 * @param string $phone Phone number as typed.
 * @return string
 */
function starter_core_tel( $phone ) {
	$phone = trim( (string) $phone );
	$plus  = str_starts_with( $phone, '+' ) ? '+' : '';
	return $plus . preg_replace( '/\D+/', '', $phone );
}

/**
 * Whether any opening hours have been entered.
 *
 * @return bool
 */
function starter_core_has_hours() {
	foreach ( starter_core_business()['hours'] as $day ) {
		if ( ! empty( $day['closed'] ) || ( '' !== $day['opens'] && '' !== $day['closes'] ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Format a stored "HH:MM" time with the site's time format.
 *
 * @param string $time Time as HH:MM.
 * @return string
 */
function starter_core_format_time( $time ) {
	$utc = new DateTimeZone( 'UTC' );
	$dt  = DateTime::createFromFormat( '!H:i', $time, $utc );
	return $dt ? wp_date( get_option( 'time_format' ), $dt->getTimestamp(), $utc ) : $time;
}

/**
 * Opening hours grouped into runs of consecutive days with the same hours,
 * e.g. Mon–Fri 9–17, Sat 10–14, Sun closed. Days with nothing entered are skipped.
 *
 * @return array<int, array{first: string, last: string, closed: bool, opens: string, closes: string}>
 */
function starter_core_hours_groups() {
	$hours  = starter_core_business()['hours'];
	$groups = array();

	foreach ( array_keys( starter_core_days() ) as $day ) {
		$h      = $hours[ $day ];
		$closed = ! empty( $h['closed'] );

		if ( ! $closed && ( '' === $h['opens'] || '' === $h['closes'] ) ) {
			$groups[] = null; // Breaks a run: unspecified days are not merged across.
			continue;
		}

		$last = end( $groups );
		if ( $last && $last['closed'] === $closed && $last['opens'] === $h['opens'] && $last['closes'] === $h['closes'] ) {
			$groups[ key( $groups ) ]['last'] = $day;
			continue;
		}

		$groups[] = array(
			'first'  => $day,
			'last'   => $day,
			'closed' => $closed,
			'opens'  => $closed ? '' : $h['opens'],
			'closes' => $closed ? '' : $h['closes'],
		);
	}

	return array_values( array_filter( $groups ) );
}

/**
 * Localised weekday name.
 *
 * @param string $day   Day key (mo…su).
 * @param bool   $short Abbreviation (ma) instead of the full name (maanantai).
 * @return string
 */
function starter_core_day_name( $day, $short = true ) {
	global $wp_locale;
	$name = $wp_locale->get_weekday( starter_core_days()[ $day ]['index'] );
	return $short ? $wp_locale->get_weekday_abbrev( $name ) : $name;
}
