<?php
/**
 * Opening hours – front end.
 *
 * A definition list: days (or runs of days) and their hours. Short day names
 * are shown visually; screen readers get the full names.
 *
 * @package StarterCore
 *
 * @var array $attributes Block attributes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! starter_core_has_hours() ) {
	// In the editor, explain where the hours come from; on the site, show nothing.
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		printf(
			'<p>%s</p>',
			esc_html__( 'No opening hours yet. Add them under Settings → Business details.', 'starter-core' )
		);
	}
	return;
}

$starter_core_short = 'long' !== ( $attributes['dayFormat'] ?? 'short' );

$starter_core_days_label = static function ( $group, $short ) {
	$first = starter_core_day_name( $group['first'], $short );
	if ( $group['first'] === $group['last'] ) {
		return $first;
	}
	return $first . '–' . starter_core_day_name( $group['last'], $short );
};
?>
<dl <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?>>
	<?php foreach ( starter_core_hours_groups() as $starter_core_group ) : ?>
		<div class="wp-block-starter-opening-hours__row">
			<dt>
				<?php if ( $starter_core_short ) : ?>
					<span aria-hidden="true"><?php echo esc_html( $starter_core_days_label( $starter_core_group, true ) ); ?></span>
					<span class="screen-reader-text"><?php echo esc_html( $starter_core_days_label( $starter_core_group, false ) ); ?></span>
				<?php else : ?>
					<?php echo esc_html( ucfirst( $starter_core_days_label( $starter_core_group, false ) ) ); ?>
				<?php endif; ?>
			</dt>
			<dd>
				<?php
				if ( $starter_core_group['closed'] ) {
					esc_html_e( 'Closed', 'starter-core' );
				} else {
					echo esc_html( starter_core_format_time( $starter_core_group['opens'] ) . '–' . starter_core_format_time( $starter_core_group['closes'] ) );
				}
				?>
			</dd>
		</div>
	<?php endforeach; ?>
</dl>
