<?php
/**
 * WebberZone ACF Country.
 *
 * Adds a 'Country' field type for Advanced Custom Fields.
 *
 * @package   WebberZone_ACF_Country
 * @author    WebberZone
 * @license   GPL-2.0+
 * @link      https://webberzone.com
 * @copyright 2026 WebberZone
 *
 * @wordpress-plugin
 * Plugin Name: WebberZone ACF Country
 * Plugin URI:  https://webberzone.github.io/webberzone-acf-country/
 * Description: Adds a 'Country' field type for Advanced Custom Fields.
 * Version:     1.0.0
 * Author:      WebberZone
 * Author URI:  https://webberzone.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: webberzone-acf-country
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Requires at least: 6.6
 * GitHub Plugin URI: https://github.com/WebberZone/webberzone-acf-country/
 */

namespace WebberZone\ACF_Country;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Holds the WebberZone ACF Country plugin version.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WZACF_VERSION' ) ) {
	define( 'WZACF_VERSION', '1.0.0' );
}

/**
 * Holds the filesystem directory path (with trailing slash) for this plugin.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WZACF_PLUGIN_DIR' ) ) {
	define( 'WZACF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Holds the URL (with trailing slash) for this plugin.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WZACF_PLUGIN_URL' ) ) {
	define( 'WZACF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Holds the main plugin file path.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WZACF_PLUGIN_FILE' ) ) {
	define( 'WZACF_PLUGIN_FILE', __FILE__ );
}

/**
 * Register the ACF Country field type.
 *
 * Hooked directly on `acf/include_field_types`, which ACF triggers itself
 * whenever it builds its list of field types. Unlike hooking a fixed WP
 * lifecycle event (e.g. `after_setup_theme`), this can never fire before or
 * after ACF is ready, so the field type always registers correctly.
 *
 * @since 1.0.0
 *
 * @param int $version ACF major version.
 */
function register_field_type( $version ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found -- required by the acf/include_field_types hook signature.
	include_once WZACF_PLUGIN_DIR . 'includes/class-country-field.php';

	acf_register_field_type( new Country_Field( untrailingslashit( WZACF_PLUGIN_URL ), untrailingslashit( WZACF_PLUGIN_DIR ) ) );
}
add_action( 'acf/include_field_types', __NAMESPACE__ . '\register_field_type' );

/**
 * Warn in wp-admin if ACF isn't active.
 *
 * @since 1.0.0
 */
function admin_notice_missing_acf() {
	if ( class_exists( 'ACF' ) ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		esc_html__( 'WebberZone ACF Country requires Advanced Custom Fields (or ACF PRO) to be installed and active.', 'webberzone-acf-country' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\admin_notice_missing_acf' );
