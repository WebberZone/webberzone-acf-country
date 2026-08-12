<?php
/**
 * PHPStan bootstrap file for WebberZone ACF Country.
 *
 * @package WebberZone_ACF_Country
 */

if ( ! defined( 'WZACF_VERSION' ) ) {
	define( 'WZACF_VERSION', '0.0.0' );
}

if ( ! defined( 'WZACF_PLUGIN_FILE' ) ) {
	define( 'WZACF_PLUGIN_FILE', '' );
}

if ( ! defined( 'WZACF_PLUGIN_DIR' ) ) {
	define( 'WZACF_PLUGIN_DIR', '' );
}

if ( ! defined( 'WZACF_PLUGIN_URL' ) ) {
	define( 'WZACF_PLUGIN_URL', '' );
}

// Advanced Custom Fields isn't part of wordpress-stubs; stub the minimal
// surface this plugin relies on so PHPStan can analyse it in isolation.
if ( ! class_exists( 'acf_field' ) ) {
	// phpcs:disable Squiz.Commenting -- minimal PHPStan-only stub.
	abstract class acf_field {

		public $name;
		public $label;
		public $category;
		public $defaults;
		public $show_in_rest;

		public function __construct() {
		}
		public function render_field( $field ) {
		}
		public function render_field_settings( $field ) {
		}
		public function render_field_validation_settings( $field ) {
		}
		public function render_field_presentation_settings( $field ) {
		}
		public function format_value( $value, $post_id, $field ) {
		}
		public function validate_value( $valid, $value, $field, $input ) {
		}
		public function load_value( $value, $post_id, $field ) {
		}
		public function update_value( $value, $post_id, $field ) {
		}
		public function load_field( $field ) {
		}
		public function update_field( $field ) {
		}
		public function delete_value( $post_id, $key ) {
		}
		public function delete_field( $field ) {
		}
		public function input_admin_enqueue_scripts() {
		}
		public function field_group_admin_enqueue_scripts() {
		}
	}
	// phpcs:enable
}

if ( ! function_exists( 'acf_get_field_type' ) ) {
	function acf_get_field_type( $name ) {
		return null;
	}
}

if ( ! function_exists( 'acf_register_field_type' ) ) {
	function acf_register_field_type( $field ) {
	}
}

if ( ! function_exists( 'acf_render_field_setting' ) ) {
	function acf_render_field_setting( $field, $setting, $global = false ) {
	}
}

if ( ! function_exists( 'acf_encode_choices' ) ) {
	function acf_encode_choices( $choices, $keys = true ) {
		return '';
	}
}
