=== WebberZone ACF Country ===
Contributors: webberzone, ajaydsouza
Tags: acf, advanced custom fields, country, field type
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.3
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

1. Download `webberzone-acf-country.zip` from [GitHub Releases](https://github.com/WebberZone/webberzone-acf-country/releases), upload it under Plugins → Add New → Upload Plugin, and activate it. Published releases also appear as updates on the Plugins screen.
2. Add a field of type "Country" to any ACF field group.

== Changelog ==

= 1.0.3 =

Release date: 24 November 2026

**Added**

* Plugins screen updates from GitHub releases.
* Plugin icon for WordPress update details and the project site.
* Multisite subsite Plugins screen update row when the plugin is active only on a site.

**Fixed**

* Version details links on multisite subsite Plugins screens (GitHub release instead of broken thickbox).

= 1.0.2 =

Release date: 3 November 2026

**Security**

* Hardened the field validation message.

= 1.0.1 =

Release date: 8 October 2026

**Changed**

* Tested with WordPress 7.1.

= 1.0.0 =

Release date: 12 August 2026

* Initial release.

== Upgrade Notice ==

= 1.0.3 =
Adds Plugins screen updates from GitHub releases. No action required on existing sites.
