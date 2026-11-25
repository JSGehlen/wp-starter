<?php
/**
 * Plugin Name:       Starter Core
 * Description:       Site functionality that must not depend on the theme: business details, contact form, opening hours, SEO fields, structured data and the preview notice.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            Jeremy Gehlen
 * Author URI:        https://jeremygehlen.com
 * License:           GPL-2.0-or-later
 * Text Domain:       starter-core
 * Domain Path:       /languages
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STARTER_CORE_VERSION', '0.1.0' );
define( 'STARTER_CORE_FILE', __FILE__ );
define( 'STARTER_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'STARTER_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once STARTER_CORE_DIR . 'includes/business.php';
require_once STARTER_CORE_DIR . 'includes/settings.php';
require_once STARTER_CORE_DIR . 'includes/bindings.php';
require_once STARTER_CORE_DIR . 'includes/cache.php';
require_once STARTER_CORE_DIR . 'includes/blocks.php';
require_once STARTER_CORE_DIR . 'includes/contact-form.php';
require_once STARTER_CORE_DIR . 'includes/seo.php';
require_once STARTER_CORE_DIR . 'includes/schema.php';
require_once STARTER_CORE_DIR . 'includes/preview.php';
require_once STARTER_CORE_DIR . 'includes/cleanup.php';

/**
 * Translations from the plugin's own languages/ folder
 * (languages/starter-core-fi.l10n.php; no .mo build needed).
 */
add_action(
	'init',
	static function () {
		load_plugin_textdomain( 'starter-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	},
	0
);
