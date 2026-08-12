<?php
/**
 * Base test case.
 *
 * ACF is not available in the WP core test environment, so we stub the
 * minimal `acf_field` surface Country_Field relies on before loading the
 * class under test. Declared at file scope because PHP does not allow
 * class declarations nested inside a function/method body.
 */

if (! class_exists('acf_field') ) {
    /**
     * Minimal test-only stub of ACF's base field class.
     */
    abstract class acf_field
    {
        /**
         * Field type name.
         *
         * @var string
         */
        public $name;

        /**
         * Field type label.
         *
         * @var string
         */
        public $label;

        /**
         * Field type category.
         *
         * @var string
         */
        public $category;

        /**
         * Field type defaults.
         *
         * @var array
         */
        public $defaults;

        /**
         * Whether the field type is shown in REST.
         *
         * @var bool
         */
        public $show_in_rest;

        /**
         * Constructor.
         */
        public function __construct()
        {
            $this->initialize();
        }
    }
}

if (! function_exists('acf_get_field_type') ) {
    /**
     * Stub of ACF's acf_get_field_type().
     *
     * @param  string $name Field type name.
     * @return null
     */
    function acf_get_field_type( $name )
    {
        return null;
    }
}

/**
 * Country_Field tests.
 */
class Base extends WP_UnitTestCase
{

    /**
     * Constants defined by the main plugin file should be present.
     */
    public function test_plugin_constants_defined()
    {
        $this->assertTrue(defined('WZACF_VERSION'));
        $this->assertTrue(defined('WZACF_PLUGIN_DIR'));
        $this->assertTrue(defined('WZACF_PLUGIN_URL'));
    }

    /**
     * get_countries() should return a code => name map including the US.
     */
    public function test_get_countries_returns_code_to_name_map()
    {
        include_once WZACF_PLUGIN_DIR . 'includes/class-country-field.php';

        $field = new WebberZone\ACF_Country\Country_Field('https://example.com', WZACF_PLUGIN_DIR);

        $countries = $field->get_countries();

        $this->assertIsArray($countries);
        $this->assertArrayHasKey('US', $countries);
        $this->assertSame('United States of America', $countries['US']);
    }

    /**
     * The wzacf_countries filter should be able to remove a country.
     */
    public function test_countries_filter_is_applied()
    {
        include_once WZACF_PLUGIN_DIR . 'includes/class-country-field.php';

        add_filter(
            'wzacf_countries',
            function ( $countries ) {
                unset($countries['US']);
                return $countries;
            }
        );

        $field     = new WebberZone\ACF_Country\Country_Field('https://example.com', WZACF_PLUGIN_DIR);
        $countries = $field->get_countries();

        $this->assertArrayNotHasKey('US', $countries);

        remove_all_filters('wzacf_countries');
    }
}
