<?php
/**
 * ACF Country field type.
 *
 * @package WebberZone_ACF_Country
 */

namespace WebberZone\ACF_Country;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Country field type.
 *
 * Delegates rendering, loading, saving and validation to ACF's built-in
 * `select` field type so saved values (country-code strings/arrays) are
 * identical to a plain ACF select field.
 */
class Country_Field extends \acf_field {



	const FORMAT_VALUE = 'value';
	const FORMAT_ARRAY = 'array';
	const FORMAT_LABEL = 'label';

	/**
	 * Plugin URL (no trailing slash).
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * Plugin path (no trailing slash).
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * The core ACF select field, used for delegation.
	 *
	 * @var \acf_field
	 */
	protected $select;

	/**
	 * Constructor.
	 *
	 * @param string $uri  Plugin URL (no trailing slash).
	 * @param string $path Plugin path (no trailing slash).
	 */
	public function __construct( $uri, $path ) {
		$this->uri  = $uri;
		$this->path = $path;

		parent::__construct();
	}

	/**
	 * Set up field type properties.
	 */
	public function initialize() {
		$this->name         = 'country';
		$this->label        = __( 'Country', 'webberzone-acf-country' );
		$this->category     = 'choice';
		$this->show_in_rest = true;
		$this->defaults     = array(
			'multiple'      => 0,
			'allow_null'    => 0,
			'choices'       => array(),
			'default_value' => '',
			'layout'        => 'vertical',
			'ui'            => 0,
			'ajax'          => 0,
			'placeholder'   => '',
			'return_format' => self::FORMAT_ARRAY,
		);
		$this->select       = acf_get_field_type( 'select' );
	}

	/**
	 * Render the field input.
	 *
	 * @param array $field Field settings.
	 */
	public function render_field( $field ) {
		$field['choices'] = $this->get_countries();
		$field['ajax']    = 0;

		if ( $field['value'] && is_array( $field['value'] ) ) {
			$field['value'] = array_map( 'strtoupper', $field['value'] );
		}

		$this->select->render_field( $field );
	}

	/**
	 * Render the field settings shown when editing a field group.
	 *
	 * @param array $field Field settings.
	 */
	public function render_field_settings( $field ) {
		$field['choices']       = acf_encode_choices( $this->get_countries() );
		$field['default_value'] = acf_encode_choices( $field['default_value'], false );

		acf_render_field_setting(
			$field,
			array(
				'label'   => __( 'Choices', 'acf' ),
				'name'    => 'choices',
				'type'    => 'textarea',
				'wrapper' => array(
					'class' => 'hidden',
				),
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Default Value', 'acf' ),
				'instructions' => __( 'Enter each default value on a new line', 'acf' ),
				'name'         => 'default_value',
				'type'         => 'textarea',
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Return Format', 'acf' ),
				'instructions' => __( 'Specify the value returned', 'acf' ),
				'type'         => 'radio',
				'name'         => 'return_format',
				'layout'       => 'horizontal',
				'choices'      => array(
					self::FORMAT_ARRAY => __( 'Country code and name', 'webberzone-acf-country' ),
					self::FORMAT_VALUE => __( 'Country code', 'webberzone-acf-country' ),
					self::FORMAT_LABEL => __( 'Country name', 'webberzone-acf-country' ),
				),
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Select multiple values?', 'acf' ),
				'instructions' => '',
				'name'         => 'multiple',
				'type'         => 'true_false',
				'ui'           => 1,
			)
		);
	}

	/**
	 * Render the validation settings tab (allow_null etc).
	 *
	 * @param array $field Field settings.
	 */
	public function render_field_validation_settings( $field ) {
		$this->select->render_field_validation_settings( $field );
	}

	/**
	 * Render the presentation settings tab.
	 *
	 * @param array $field Field settings.
	 */
	public function render_field_presentation_settings( $field ) {
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Stylised UI', 'acf' ),
				'instructions' => __( 'Use a stylised checkbox using select2', 'acf' ),
				'name'         => 'ui',
				'type'         => 'true_false',
				'ui'           => 1,
			)
		);
	}

	/**
	 * Format the value for display/use in templates.
	 *
	 * @param  mixed $value   The raw field value.
	 * @param  int   $post_id The post ID.
	 * @param  array $field   Field settings.
	 * @return mixed
	 */
	public function format_value( $value, $post_id, $field ) {
		$field['choices'] = $this->get_countries();

		return $this->select->format_value( $value, $post_id, $field );
	}

	/**
	 * Validate a submitted value.
	 *
	 * @param  bool  $valid Whether the value is valid.
	 * @param  mixed $value The submitted value.
	 * @param  array $field Field settings.
	 * @param  array $input The input name.
	 * @return bool|string
	 */
	public function validate_value( $valid, $value, $field, $input ) {
		if ( empty( $value ) ) {
			return $valid;
		}

		$countries = array_keys( $this->get_countries() );

		if ( is_array( $value ) ) {
			$invalid = array_diff( $value, $countries );

			if ( count( $invalid ) !== 0 ) {
				/* translators: %s: comma-separated list of invalid country codes. */
				$valid = sprintf( _n( '%s is not a valid country code', '%s are not valid country codes', count( $invalid ), 'webberzone-acf-country' ), implode( ', ', $invalid ) );
			}
		} elseif ( is_string( $value ) && ! in_array( $value, $countries, true ) ) {
			/* translators: %s: invalid country code. */
			$valid = sprintf( __( '%s is not a valid country code', 'webberzone-acf-country' ), $value );
		}

		return $valid;
	}

	/**
	 * Filter the value after loading from the database.
	 *
	 * @param  mixed $value   The raw field value.
	 * @param  int   $post_id The post ID.
	 * @param  array $field   Field settings.
	 * @return mixed
	 */
	public function load_value( $value, $post_id, $field ) {
		return $this->select->load_value( $value, $post_id, $field );
	}

	/**
	 * Filter the value before saving to the database.
	 *
	 * @param  mixed $value   The value to save.
	 * @param  int   $post_id The post ID.
	 * @param  array $field   Field settings.
	 * @return mixed
	 */
	public function update_value( $value, $post_id, $field ) {
		return $this->select->update_value( $value, $post_id, $field );
	}

	/**
	 * Filter the field before saving to the database.
	 *
	 * @param  array $field Field settings.
	 * @return array
	 */
	public function update_field( $field ) {
		return $this->select->update_field( $field );
	}

	/**
	 * Enqueue assets for the field input.
	 */
	public function input_admin_enqueue_scripts() {
		$this->select->input_admin_enqueue_scripts();

		wp_enqueue_script( $this->name, $this->uri . '/assets/js/field.js', array( 'jquery', 'acf-input' ), WZACF_VERSION, true );
	}

	/**
	 * Enqueue assets shown when editing a field group.
	 */
	public function field_group_admin_enqueue_scripts() {
		$this->input_admin_enqueue_scripts();

		wp_enqueue_style( $this->name, $this->uri . '/assets/css/field.css', array(), WZACF_VERSION );
	}

	/**
	 * Get the list of countries, code => name.
	 *
	 * @return array<string,string>
	 */
	public function get_countries() {
		$countries = include $this->path . '/includes/data/countries.php';

		/**
		 * Filter the list of countries available to the Country field.
		 *
		 * @param array<string,string> $countries Country code => name.
		 */
		return apply_filters( 'wzacf_countries', $countries );
	}
}
