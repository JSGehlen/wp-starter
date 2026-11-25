<?php
/**
 * Settings → Business details: the owner edits name, address, contact details
 * and opening hours here once, and they appear everywhere on the site.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * schema.org types offered in the "Business type" select. Add a client's own
 * type here if it is missing (any LocalBusiness subtype is valid).
 *
 * @return array<string, string> Type => label.
 */
function starter_core_business_types() {
	return apply_filters(
		'starter_core_business_types',
		array(
			'LocalBusiness'               => __( 'Local business (general)', 'starter-core' ),
			'Store'                       => __( 'Store', 'starter-core' ),
			'Restaurant'                  => __( 'Restaurant', 'starter-core' ),
			'CafeOrCoffeeShop'            => __( 'Café', 'starter-core' ),
			'Bakery'                      => __( 'Bakery', 'starter-core' ),
			'HairSalon'                   => __( 'Hair salon', 'starter-core' ),
			'BeautySalon'                 => __( 'Beauty salon', 'starter-core' ),
			'HealthAndBeautyBusiness'     => __( 'Health and beauty', 'starter-core' ),
			'MedicalBusiness'             => __( 'Medical or therapy practice', 'starter-core' ),
			'Dentist'                     => __( 'Dentist', 'starter-core' ),
			'ProfessionalService'         => __( 'Professional service', 'starter-core' ),
			'HomeAndConstructionBusiness' => __( 'Home and construction', 'starter-core' ),
			'AutoRepair'                  => __( 'Car repair', 'starter-core' ),
			'SportsActivityLocation'      => __( 'Sports and fitness', 'starter-core' ),
			'LodgingBusiness'             => __( 'Accommodation', 'starter-core' ),
			'Farm'                        => __( 'Farm', 'starter-core' ),
		)
	);
}

add_action(
	'admin_init',
	static function () {
		register_setting(
			'starter_core_business',
			STARTER_CORE_OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => 'starter_core_sanitize_business',
				'default'           => array(),
			)
		);
	}
);

add_action(
	'admin_menu',
	static function () {
		add_options_page(
			__( 'Business details', 'starter-core' ),
			__( 'Business details', 'starter-core' ),
			'manage_options',
			'starter-core-business',
			'starter_core_render_settings_page'
		);
	}
);

/**
 * Sanitise the submitted settings.
 *
 * @param mixed $input Raw input.
 * @return array
 */
function starter_core_sanitize_business( $input ) {
	// options.php has already unslashed the submitted values.
	$input = is_array( $input ) ? $input : array();
	$clean = starter_core_business_defaults();
	$text  = static function ( $key ) use ( $input ) {
		return isset( $input[ $key ] ) ? sanitize_text_field( (string) $input[ $key ] ) : '';
	};

	foreach ( array( 'name', 'street', 'postal_code', 'city', 'phone' ) as $key ) {
		$clean[ $key ] = $text( $key );
	}

	$clean['type']    = array_key_exists( $text( 'type' ), starter_core_business_types() ) ? $text( 'type' ) : 'LocalBusiness';
	$clean['country'] = preg_match( '/^[A-Za-z]{2}$/', $text( 'country' ) ) ? strtoupper( $text( 'country' ) ) : 'FI';
	$clean['email']   = sanitize_email( $text( 'email' ) );
	$clean['form_to'] = sanitize_email( $text( 'form_to' ) );
	$clean['map_url'] = esc_url_raw( $text( 'map_url' ), array( 'https' ) );

	foreach ( array( 'latitude', 'longitude' ) as $key ) {
		$value         = str_replace( ',', '.', $text( $key ) );
		$clean[ $key ] = is_numeric( $value ) ? (string) (float) $value : '';
	}

	// A textarea (one URL per line) when submitted, already an array when
	// WordPress sanitises a newly created option a second time.
	$same_as = $input['same_as'] ?? array();
	if ( ! is_array( $same_as ) ) {
		$same_as = preg_split( '/\R/', (string) $same_as );
	}
	$clean['same_as'] = array_values(
		array_filter(
			array_map(
				static fn( $url ) => str_starts_with( trim( (string) $url ), 'https://' ) ? esc_url_raw( trim( (string) $url ), array( 'https' ) ) : '',
				$same_as
			)
		)
	);

	$time = static fn( $value ) => preg_match( '/^([01]\d|2[0-3]):[0-5]\d$/', (string) $value ) ? (string) $value : '';
	foreach ( array_keys( starter_core_days() ) as $day ) {
		$h                      = isset( $input['hours'][ $day ] ) && is_array( $input['hours'][ $day ] ) ? $input['hours'][ $day ] : array();
		$clean['hours'][ $day ] = array(
			'closed' => ! empty( $h['closed'] ),
			'opens'  => $time( $h['opens'] ?? '' ),
			'closes' => $time( $h['closes'] ?? '' ),
		);
	}

	return $clean;
}

/**
 * The settings page.
 */
function starter_core_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$data  = starter_core_business();
	$name  = STARTER_CORE_OPTION;
	$field = static function ( $key, $label, $type = 'text', $attrs = '', $help = '' ) use ( $data, $name ) {
		$id = 'starter-core-' . $key;
		?>
		<tr>
			<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<input type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name . '[' . $key . ']' ); ?>" value="<?php echo esc_attr( $data[ $key ] ); ?>" class="regular-text" <?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static attributes from this file. ?> <?php echo $help ? 'aria-describedby="' . esc_attr( $id ) . '-help"' : ''; ?> />
				<?php if ( $help ) : ?>
					<p class="description" id="<?php echo esc_attr( $id ); ?>-help"><?php echo esc_html( $help ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	};
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Business details', 'starter-core' ); ?></h1>
		<p><?php esc_html_e( 'These details appear in the footer, on the contact and location sections, in the opening hours and in the information shown to search engines. Change them here and they update everywhere.', 'starter-core' ); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields( 'starter_core_business' ); ?>

			<h2><?php esc_html_e( 'Business', 'starter-core' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php $field( 'name', __( 'Business name', 'starter-core' ), 'text', '', __( 'Leave empty to use the site title.', 'starter-core' ) ); ?>
				<tr>
					<th scope="row"><label for="starter-core-type"><?php esc_html_e( 'Business type', 'starter-core' ); ?></label></th>
					<td>
						<select id="starter-core-type" name="<?php echo esc_attr( $name ); ?>[type]" aria-describedby="starter-core-type-help">
							<?php foreach ( starter_core_business_types() as $type => $label ) : ?>
								<option value="<?php echo esc_attr( $type ); ?>" <?php selected( $data['type'], $type ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
						<p class="description" id="starter-core-type-help"><?php esc_html_e( 'Tells search engines what kind of business this is.', 'starter-core' ); ?></p>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Address and contact details', 'starter-core' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$field( 'street', __( 'Street address', 'starter-core' ), 'text', 'autocomplete="off"' );
				$field( 'postal_code', __( 'Postal code', 'starter-core' ), 'text', 'inputmode="numeric" autocomplete="off"' );
				$field( 'city', __( 'City', 'starter-core' ) );
				$field( 'country', __( 'Country code', 'starter-core' ), 'text', 'maxlength="2" style="width:4em"', __( 'Two letters, e.g. FI.', 'starter-core' ) );
				$field( 'phone', __( 'Phone', 'starter-core' ), 'tel' );
				$field( 'email', __( 'Email', 'starter-core' ), 'email' );
				$field( 'map_url', __( 'Map link', 'starter-core' ), 'url', '', __( 'Optional. Leave empty to link to Google Maps with the address above.', 'starter-core' ) );
				$field( 'latitude', __( 'Latitude', 'starter-core' ), 'text', 'inputmode="decimal"', __( 'Optional, for search engines. E.g. 60.1699', 'starter-core' ) );
				$field( 'longitude', __( 'Longitude', 'starter-core' ), 'text', 'inputmode="decimal"', __( 'Optional. E.g. 24.9384', 'starter-core' ) );
				?>
				<tr>
					<th scope="row"><label for="starter-core-same_as"><?php esc_html_e( 'Social media profiles', 'starter-core' ); ?></label></th>
					<td>
						<textarea id="starter-core-same_as" name="<?php echo esc_attr( $name ); ?>[same_as]" rows="3" class="large-text" aria-describedby="starter-core-same_as-help"><?php echo esc_textarea( implode( "\n", $data['same_as'] ) ); ?></textarea>
						<p class="description" id="starter-core-same_as-help"><?php esc_html_e( 'One address per line, e.g. https://www.facebook.com/… For search engines; the icons in the footer are edited in the site editor.', 'starter-core' ); ?></p>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Opening hours', 'starter-core' ); ?></h2>
			<p><?php esc_html_e( 'Leave a day empty if it should not be shown. Exceptions such as public holidays are written on the page itself.', 'starter-core' ); ?></p>
			<table class="form-table starter-core-hours" role="presentation">
				<?php foreach ( array_keys( starter_core_days() ) as $day ) : ?>
					<?php
					$h    = $data['hours'][ $day ];
					$base = $name . '[hours][' . $day . ']';
					$id   = 'starter-core-hours-' . $day;
					?>
					<tr>
						<th scope="row"><?php echo esc_html( ucfirst( starter_core_day_name( $day, false ) ) ); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><?php echo esc_html( ucfirst( starter_core_day_name( $day, false ) ) ); ?></legend>
								<label for="<?php echo esc_attr( $id ); ?>-opens"><?php esc_html_e( 'Opens', 'starter-core' ); ?></label>
								<input type="time" id="<?php echo esc_attr( $id ); ?>-opens" name="<?php echo esc_attr( $base ); ?>[opens]" value="<?php echo esc_attr( $h['opens'] ); ?>" />
								<label for="<?php echo esc_attr( $id ); ?>-closes"><?php esc_html_e( 'Closes', 'starter-core' ); ?></label>
								<input type="time" id="<?php echo esc_attr( $id ); ?>-closes" name="<?php echo esc_attr( $base ); ?>[closes]" value="<?php echo esc_attr( $h['closes'] ); ?>" />
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $base ); ?>[closed]" value="1" <?php checked( $h['closed'] ); ?> />
									<?php esc_html_e( 'Closed', 'starter-core' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

			<h2><?php esc_html_e( 'Contact form', 'starter-core' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php $field( 'form_to', __( 'Send form messages to', 'starter-core' ), 'email', '', __( 'Leave empty to use the email address above.', 'starter-core' ) ); ?>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<style>
		.starter-core-hours fieldset { display: flex; flex-wrap: wrap; gap: 0.5rem 1rem; align-items: center; }
		.starter-core-hours fieldset > label:last-child { margin-inline-start: 0.5rem; }
	</style>
	<?php
}

/**
 * "Settings" link on the Plugins screen.
 */
add_filter(
	'plugin_action_links_' . plugin_basename( STARTER_CORE_FILE ),
	static function ( $links ) {
		array_unshift( $links, '<a href="' . esc_url( admin_url( 'options-general.php?page=starter-core-business' ) ) . '">' . esc_html__( 'Business details', 'starter-core' ) . '</a>' );
		return $links;
	}
);
