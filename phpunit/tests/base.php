<?php
/**
 * Base test case. ACF is not available in the WP core test environment,
 * so we stub the minimal `acf_field` surface Country_Field relies on
 * before loading the class under test.
 */
class Base extends WP_UnitTestCase {


	public function test_plugin_constants_defined() {
		$this->assertTrue( defined( 'WZACF_VERSION' ) );
		$this->assertTrue( defined( 'WZACF_PLUGIN_DIR' ) );
		$this->assertTrue( defined( 'WZACF_PLUGIN_URL' ) );
	}

	public function test_get_countries_returns_code_to_name_map() {
		if ( ! class_exists( 'acf_field' ) ) {
         // phpcs:ignore Squiz.Commenting -- minimal test-only stub of ACF's base field class.
			abstract class acf_field {

				public $name;
				public $label;
				public $category;
				public $defaults;
				public $show_in_rest;
				public function __construct() {
					$this->initialize();
				}
			}
		}

		if ( ! function_exists( 'acf_get_field_type' ) ) {
			function acf_get_field_type( $name ) {
				return null;
			}
		}

		include_once WZACF_PLUGIN_DIR . 'includes/class-country-field.php';

		$field = new WebberZone\ACF_Country\Country_Field( 'https://example.com', WZACF_PLUGIN_DIR );

		$countries = $field->get_countries();

		$this->assertIsArray( $countries );
		$this->assertArrayHasKey( 'US', $countries );
		$this->assertSame( 'United States of America', $countries['US'] );
	}

	public function test_countries_filter_is_applied() {
		if ( ! class_exists( 'WebberZone\ACF_Country\Country_Field' ) ) {
			$this->markTestSkipped( 'Country_Field not loaded.' );
		}

		add_filter(
			'wzacf_countries',
			function ( $countries ) {
				unset( $countries['US'] );
				return $countries;
			}
		);

		$field     = new WebberZone\ACF_Country\Country_Field( 'https://example.com', WZACF_PLUGIN_DIR );
		$countries = $field->get_countries();

		$this->assertArrayNotHasKey( 'US', $countries );

		remove_all_filters( 'wzacf_countries' );
	}
}
