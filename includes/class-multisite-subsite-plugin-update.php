<?php
/**
 * Show plugin update rows on multisite subsite Plugins screens.
 *
 * Core only prints update rows in network admin or on single-site installs
 * (see wp_plugin_update_row()).
 *
 * @package WebberZone_ACF_Country
 */

namespace WebberZone\ACF_Country;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Multisite subsite plugin update UI.
 *
 * @since 1.0.3
 */
class Multisite_Subsite_Plugin_Update {

	/**
	 * Register hooks.
	 *
	 * @since 1.0.3
	 */
	public static function init(): void {
		if ( ! is_multisite() ) {
			return;
		}

		add_action( 'load-plugins.php', array( self::class, 'maybe_register_row' ), 25 );
	}

	/**
	 * Register the update row callback when this plugin has an update on the current site.
	 *
	 * @since 1.0.3
	 */
	public static function maybe_register_row(): void {
		if ( is_network_admin() || ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		if ( ! apply_filters( 'wzacf_enable_multisite_subsite_update_row', true ) ) {
			return;
		}

		$plugin_file = plugin_basename( WZACF_PLUGIN_FILE );
		$current     = get_site_transient( 'update_plugins' );

		if ( empty( $current->response[ $plugin_file ] ) ) {
			return;
		}

		add_action( "after_plugin_row_{$plugin_file}", array( self::class, 'render_row' ), 10, 2 );
	}

	/**
	 * Output the update row (mirrors core markup for the multisite subsite case).
	 *
	 * @since 1.0.3
	 *
	 * @param string $file        Plugin basename.
	 * @param array  $plugin_data Plugin header data.
	 */
	public static function render_row( $file, $plugin_data ): void {
		$current = get_site_transient( 'update_plugins' );

		if ( empty( $current->response[ $file ] ) ) {
			return;
		}

		$response = $current->response[ $file ];

		$plugin_name = esc_html( $plugin_data['Name'] );
		$plugin_slug = $response->slug ?? $response->id;

		if ( isset( $response->slug ) ) {
			$details_url = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&section=changelog' );
		} elseif ( isset( $response->url ) ) {
			$details_url = $response->url;
		} else {
			$details_url = $plugin_data['PluginURI'];
		}

		$details_url = add_query_arg(
			array(
				'TB_iframe' => 'true',
				'width'     => 600,
				'height'    => 800,
			),
			$details_url
		);

		/** @var \WP_Plugins_List_Table $wp_list_table */
		$wp_list_table = _get_list_table(
			'WP_Plugins_List_Table',
			array(
				'screen' => get_current_screen(),
			)
		);

		$active_class   = is_plugin_active( $file ) ? ' active' : '';
		$requires_php   = $response->requires_php ?? null;
		$compatible_php = is_php_version_compatible( $requires_php );
		$notice_type    = $compatible_php ? 'notice-warning' : 'notice-error';

		printf(
			'<tr class="plugin-update-tr%s" id="%s" data-slug="%s" data-plugin="%s">' .
			'<td colspan="%s" class="plugin-update colspanchange">' .
			'<div class="update-message notice inline %s notice-alt"><p>',
			$active_class,
			esc_attr( $plugin_slug . '-update' ),
			esc_attr( $plugin_slug ),
			esc_attr( $file ),
			esc_attr( $wp_list_table->get_column_count() ),
			esc_attr( $notice_type )
		);

		if ( empty( $response->package ) ) {
			printf(
				/* translators: 1: Plugin name, 2: Details URL, 3: Additional link attributes, 4: Version number. */
				__( 'There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a>. <em>Automatic update is unavailable for this plugin.</em>', 'webberzone-acf-country' ),
				$plugin_name,
				esc_url( $details_url ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr(
						sprintf(
							/* translators: 1: Plugin name, 2: Version number. */
							__( 'View %1$s version %2$s details', 'webberzone-acf-country' ),
							$plugin_name,
							$response->new_version
						)
					)
				),
				esc_attr( $response->new_version )
			);
		} elseif ( $compatible_php ) {
			printf(
				/* translators: 1: Plugin name, 2: Details URL, 3: Additional link attributes, 4: Version number, 5: Update URL, 6: Additional link attributes. */
				__( 'There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.', 'webberzone-acf-country' ),
				$plugin_name,
				esc_url( $details_url ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr(
						sprintf(
							/* translators: 1: Plugin name, 2: Version number. */
							__( 'View %1$s version %2$s details', 'webberzone-acf-country' ),
							$plugin_name,
							$response->new_version
						)
					)
				),
				esc_attr( $response->new_version ),
				esc_url(
					wp_nonce_url(
						self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file,
						'upgrade-plugin_' . $file
					)
				),
				sprintf(
					'class="update-link" aria-label="%s"',
					esc_attr(
						sprintf(
							/* translators: %s: Plugin name. */
							_x( 'Update %s now', 'plugin', 'webberzone-acf-country' ),
							$plugin_name
						)
					)
				)
			);
		} else {
			printf(
				/* translators: 1: Plugin name, 2: Details URL, 3: Additional link attributes, 4: Version number 5: URL to Update PHP page. */
				__( 'There is a new version of %1$s available, but it does not work with your version of PHP. <a href="%2$s" %3$s>View version %4$s details</a> or <a href="%5$s">learn more about updating PHP</a>.', 'webberzone-acf-country' ),
				$plugin_name,
				esc_url( $details_url ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr(
						sprintf(
							/* translators: 1: Plugin name, 2: Version number. */
							__( 'View %1$s version %2$s details', 'webberzone-acf-country' ),
							$plugin_name,
							$response->new_version
						)
					)
				),
				esc_attr( $response->new_version ),
				esc_url( wp_get_update_php_url() )
			);
			wp_update_php_annotation( '<br><em>', '</em>' );
		}

		/**
		 * Fires at the end of the update message container in each
		 * row of the plugins list table.
		 *
		 * @since 1.0.3
		 *
		 * @param array  $plugin_data Plugin metadata.
		 * @param object $response    Available update metadata.
		 */
		do_action( "in_plugin_update_message-{$file}", $plugin_data, $response );

		echo '</p></div></td></tr>';
	}
}
