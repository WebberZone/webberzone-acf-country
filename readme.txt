=== WebberZone ACF Country ===
Contributors: webberzone, ajaydsouza
Tags: acf, advanced custom fields, country, field type
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a 'Country' field type for Advanced Custom Fields.

== Description ==

WebberZone ACF Country adds a `country` field type to [Advanced Custom Fields](https://www.advancedcustomfields.com/) (works with ACF and ACF PRO). It displays a select field of all countries (English names, ISO 3166-1 codes).

Field configuration and saved values use the same structure as a standard ACF select field, so switching from another Country field-type plugin that follows the same convention requires no data migration.

= Field options =

* Allow null
* Allow multiple
* Default value
* Return format: country code and name, country code only, or country name only

= Filters =

Remove or add countries with the `wzacf_countries` filter:

`
add_filter( 'wzacf_countries', function( $countries ) {
	unset( $countries['AQ'] ); // Remove Antarctica.
	return $countries;
} );
`

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/webberzone-acf-country`, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add a field of type "Country" to any ACF field group.

== Changelog ==

= 1.0.0 =
* Initial release.
