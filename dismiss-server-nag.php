<?php 
/*
Plugin Name:       Dismiss Server Nag
Plugin URI:        https://github.com/luciano-croce/dismiss-server-nag/
Description:       Dismiss <em>coming soon</em> "<strong>Server Happy</strong>" nag, dashboard widget, when is activated, or automatically, if it is in mu-plugins directory.
Version:           1.0.1
Requires at least: 2.3
Tested up to:      5.0
Requires PHP:      5.2.4
Author:            Luciano Croce
Author URI:        https://github.com/luciano-croce/
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:       dismiss-server-nag
Domain Path:       /languages
Network:           true
GitHub Plugin URI: https://github.com/luciano-croce/dismiss-server-nag/
GitHub Branch:     master
Requires WP:       2.3
 *
 * Warning: to avoid code corruption, do not edit this file with WordPress embedded editor,
 * or with an editor not compatible UTF-8 without BOM Unix LF
 *
 * Plugin approved in the repository of the plugin directory on 2018-01-11
 *
 * Copyright 2018 Luciano Croce (email: luciano.croce@gmail.com)
 *
 * According to the terms of the GNU General Public License, part of Copyright belongs to its own author,
 * and part belongs to other respective their authors, if exist.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other compatible version of the GPL, or version compatible with GPL.
 *
 * This program is distributed in the hope that it will be useful, on an "AS IS", but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This program is written with the intent of being helpful,
 * but you are responsible for its use or actions on your own website.
 *
 * According to the terms of the Detailed Plugin Guidelines (wordpress.org) in particular:
 * - This developer(s) are responsible(s) for the contents and actions of this plugin.
 * - Stable version of this plugin is only available from the WordPress Plugin Directory page.
 * - Plugin version numbers is be incremented for each new release.
 * - Complete plugin was be available on GitHub before the time of submission.
 * - This plugin respect trademarks, copyrights, and project names.
 *
 * Tips - A neat trick, is to put this single file dismiss-server-nag.php (not its parent directory)
 * in the /wp-content/mu-plugins/ directory (create it if not exists) so you won't even have to enable it,
 * and will be loaded by default, also, since first step installation of WordPress setup!
 *
 * Translation - All readable text of this plugin are code free,
 * no HTML tags was inserted (showed) on Text Domain strings of GlotPress.
 *
 * The code of this plugin is not written with a php framework, but with a simple php editor, manually.
 */

	/**
	 * Dismiss Server Nag
	 *
	 * Dismiss automatically Server Happy nagging on dashboard.
	 *
	 * PHPDocumentor
	 *
	 * @package    WordPress\Plugin
	 * @subpackage Dashboard\Dismiss_Server_Nag
	 * @link       https://wordpress.org/plugins/dismiss-server-nag/ - Hosted on wordpress.org repository
	 * @version    1.0.1 (Build 2018-01-11) Stable
	 * @since      1.0.0 (Build 2018-01-11) 1st Release
	 * @author     Luciano Croce <luciano.croce@gmail.com>
	 * @copyright  2013-2018 - Luciano Croce
	 * @license    https://www.gnu.org/licenses/gpl-2.0.html - GPLv2 or later
	 * @todo       Preemptive support for WordPress 5.0-alpha
	 */

/**
 * Prevent direct access to plugin files.
 *
 * For security reasons, exit without any notifications:
 * - without show the details of the system
 * - without warn the existence of this plugin
 * - show the generic header 403 forbidden error
 * - close the connection header
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 1.0.1 (Build 2018-01-11)
 * @since   1.0.0 (Build 2018-01-11)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! defined(  'WPINC'  ) ) exit;

if ( ! function_exists( 'add_action' ) ) {
	header( 'HTTP/0.9 403 Forbidden' );
	header( 'HTTP/1.0 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	header( 'HTTP/2.0 403 Forbidden' );
	header( 'Status:  403 Forbidden' );
	header( 'Connection: Close'      );
		exit;
}

global $wp_version; $wpmu_version;
include( ABSPATH . WPINC . '/version.php' );
$version = str_replace( '-src', '', $wp_version );

/**
 * Make sure that run under PHP 5.2.4 or greater
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 1.0.1 (Build 2018-01-11)
 * @since   1.0.0 (Build 2018-01-11)
 */
if ( version_compare( PHP_VERSION, '5.2.4', '<' ) ) {
// wp_die( __( 'This plugin requires PHP 5.2.4 or greater: Activation Stopped! Please note that a good choice is PHP 5.6+ ~ 7.1+ (previous stable branch) or PHP 7.2+ (current stable branch).', 'dismiss-server-nag' ) ); # uncomment it if you prefer die notification

	add_action( 'admin_init', 'ddwsun_psd_php_version_init', 0 );
	add_action( 'admin_notices', 'ddwsun_ant_php_version_init' );
	add_action( 'network_admin_notices',  'ddwsun_ant_php_version_init' );

	/**
	 * Plugin Self Deactivated when PHP version not meet minimum requirements requested
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_psd_php_version_init() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	/**
	 * Show Admin Notice when PHP version not meet minimum requirements requested
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_ant_php_version_init() {
		?>
		<div class="notice notice-error is-dismissible error">
		<p>
		<?php _e( 'This plugin requires PHP 5.2.4 or greater: please note that a good choice is PHP 5.6+ ~ 7.1+ (previous stable branch) or PHP 7.2+ (current stable branch).', 'dismiss-server-nag' );?>
		</p>
		</div>
		<div class="notice notice-warning is-dismissible updated">
		<p>
		<?php _e( 'Plugin', 'dismiss-server-nag' ) . ' ' . _e( 'Dismiss Server Nag', 'dismiss-server-nag' ) . ' ' . '<strong>' . _e( 'not activated', 'dismiss-server-nag' ) . '</strong>' . '.';?>
		<script>window.jQuery && jQuery( function( $ ) { $( 'div#message.updated' ).remove(); } );</script> <!-- This script remove update message when plugin is auto deactivated -->
		</p>
		</div>
		<?php 
	}
}

/**
 * Make sure that run under WP 2.3+ or greater
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 1.0.1 (Build 2018-01-11)
 * @since   1.0.0 (Build 2018-01-11)
 */
if ( version_compare( $version, '2.3', '<' ) ) {
// wp_die( __( 'This plugin requires WordPress 2.3+ or greater: Activation Stopped! Please note that the Core Update Nag was introduced since WordPress 2.3+', 'dismiss-server-nag' ) ); # uncomment it if you prefer die notification

	add_action( 'admin_init', 'ddwsun_psd_wp_version_init', 0 );
	add_action( 'admin_notices', 'ddwsun_ant_wp_version_init' );
	add_action( 'network_admin_notices',  'ddwsun_ant_wp_version_init' );

	/**
	 * Plugin Self Deactivated when PHP version not meet minimum requirements requested
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_psd_wp_version_init() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	/**
	 * Show Admin Notice when WP version not meet minimum requirements requested
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_ant_wp_version_init() {
		?>
		<div class="notice notice-error is-dismissible error">
		<p>
		<?php _e( 'This plugin requires WordPress 2.3+ or greater: please note that the Core Update Nag was introduced since WordPress 2.3+', 'dismiss-server-nag' );?>
		</p>
		</div>
		<div class="notice notice-warning is-dismissible updated">
		<p>
		<?php _e( 'Plugin', 'dismiss-server-nag' ) . ' - ' . _e( 'Dismiss Server Nag', 'dismiss-server-nag' ) . ' - ' . '<strong>' . _e( 'not activated', 'dismiss-server-nag' ) . '</strong>' . '.';?>
		<script>window.jQuery && jQuery( function( $ ) { $( 'div#message.updated' ).remove(); } );</script> <!-- This script remove update message when plugin is auto deactivated -->
		</p>
		</div>
		<?php 
	}
}
else {
	add_filter( 'plugins_loaded', 'ddwsun_load_plugin_textdomain' );
	if ( version_compare( $version, '3.0', '>=' ) ) {
		add_filter( 'plugins_loaded', 'ddwsun_load_muplugin_textdomain' );
	}
	add_filter( 'plugin_row_meta', 'ddwsun_adds_row_meta_build', 10, 4 );                                                       # comment or uncomment to enable or disable this customization
	if ( version_compare( $version, '4.0', '>=' ) ) {
		add_filter( 'plugin_row_meta', 'ddwsun_adds_row_meta_links', 10, 2 );                                                   # comment or uncomment to enable or disable this customization
	}
	if ( version_compare( $version, '4.0', '<' ) ) {
		if ( version_compare( $version, '2.5', '>=' ) ) {
			add_filter( 'plugin_row_meta', 'ddwsun_adds_row_meta_details', 10, 2 );                                             # comment or uncomment to enable or disable this customization
		}
	}
	if ( version_compare( $version, '3.0', '>=' ) ) {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ddwsun_adds_action_links', 10, 4 );                  # comment or uncomment to enable or disable this customization
	}
	if ( version_compare( $version, '3.0', '<' ) ) {
		if ( version_compare( $version, '2.9', '>=' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ddwsun_adds_action_links_shift', 10, 4 );        # comment or uncomment to enable or disable this customization
		}
	}
	if ( version_compare( $version, '2.9', '<' ) ) {
		if ( version_compare( $version, '2.8', '>=' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ddwsun_adds_action_links_shift', 10, 4 );        # comment or uncomment to enable or disable this customization
		}
	}
	if ( version_compare( $version, '2.8', '<' ) ) {
		if ( version_compare( $version, '2.7', '>=' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ddwsun_adds_action_links_unshift', 10, 4 );      # comment or uncomment to enable or disable this customization
		}
	}
	if ( version_compare( $version, '3.0', '>=' ) ) {
		add_filter( 'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ), 'ddwsun_adds_action_links', 10, 4 );    # comment or uncomment to enable or disable this customization
	}
	if ( version_compare( $version, '3.0', '>=' ) ) {
		add_filter( 'wp_dashboard_setup',         'ddwsun_dismiss_core_update_maintenance_nag', 100 ); # 2.7+ to 4.9+ ~ 5.0-alpha
	}
	if ( version_compare( $version, '3.1', '>=' ) ) {
		add_filter( 'wp_user_dashboard_setup',    'ddwsun_dismiss_core_update_maintenance_nag', 100 ); # 3.1+ to 4.9+ ~ 5.0-alpha 
	}
	if ( version_compare( $version, '3.1', '>=' ) ) {
		add_filter( 'wp_network_dashboard_setup', 'ddwsun_dismiss_core_update_maintenance_nag', 100 ); # 3.1+ to 4.9+ ~ 5.0-alpha
	}
	add_filter( 'admin_init',                           'dismiss_dashboard_widget_server_happy_nag' ); # 4.9+ to 5.0-alpha ~ draft
	add_filter( 'admin_init',                            'remove_dashboard_widget_server_happy_nag' ); # 4.9+ to 5.0-alpha ~ draft

	/**
	 * Load Plugin Textdomain
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_load_plugin_textdomain() {
		load_plugin_textdomain( 'dismiss-server-nag', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Load MU-Plugin (dir) Textdomain
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_load_muplugin_textdomain() {
		load_muplugin_textdomain( 'dismiss-server-nag', basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Adds Plugin Row Meta Build
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_adds_row_meta_build( $plugin_meta, $plugin_file ) {
		if ( $plugin_file == plugin_basename( __FILE__ ) )
			{
				$plugin_meta[ 0 ] .= ' | ' . __( 'Release', 'dismiss-server-nag' ) . ' ' . __( '2018-01-11', 'dismiss-server-nag' );
			}
		return $plugin_meta;
	}

	/**
	 * Adds Plugin Row Meta Details
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_adds_row_meta_details( $plugin_meta, $plugin_file ) {
		if ( $plugin_file == plugin_basename( __FILE__ ) )
			{
				$plugin_meta[] .= '<a class="thickbox" href="plugin-install.php?tab=plugin-information&amp;plugin=dismiss-server-nag&amp;section=changelog&amp;TB_iframe=true">' . __( 'View details', 'dismiss-server-nag' ) . '</a>';
			}
		return $plugin_meta;
	}

	/**
	 * Adds Plugin Row Meta Links
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_adds_row_meta_links( $plugin_meta, $plugin_file ) {
		if ( $plugin_file == plugin_basename( __FILE__ ) )
			{
				$plugin_meta[] .= '<a href="https://github.com/luciano-croce/dismiss-server-nag/">' . __( 'Visit plugin site', 'dismiss-server-nag' ) . '</a>';
			}
		return $plugin_meta;
	}

	/**
	 * Adds Plugin Action Links
	 *
	 * @author  Luciano Croce <luciano.croce@gmail.com>
	 * @version 1.0.1 (Build 2018-01-11)
	 * @since   1.0.0 (Build 2018-01-11)
	 */
	function ddwsun_adds_action_links( $plugin_meta, $plugin_file ) {
		if ( current_user_can( 'manage_options' ) ) {
			$plugin_meta[] .= '<a href="index.php" style="color:#3db634">' . __( 'Dashboard', 'dismiss-server-nag' ) . '</a>';
		}
			return $plugin_meta;
	}

	/**
	* Dismiss Dashboard Widget Server Happy Nag - ddwsun
	*
	* @author  Luciano Croce <luciano.croce@gmail.com>
	* @version 1.0.1 (Build 2018-01-11)
	* @since   1.0.0 (Build 2018-01-11)
	*/
	function dismiss_dashboard_widget_server_happy_nag() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['high']['dashboard_server_nag']);      # draft
		unset($wp_meta_boxes['dashboard']['normal']['high']['dashboard_serverhappy_nag']); # draft
	}

	/**
	* Remove Dashboard Widget Server Happy Nag - ddwsun
	*
	* This, is different from the other similar plugins, because uses the filter hook, and not the action hook.
	*
	* Filters should filter information, thus receiving information/data, applying the filter and returning information/data,
	* and then used. However, filters are still action hooks. WordPress defines add_filter/remove_filter as "hooks a function
	* to a specific filter action", and add_action/remove_action as "hooks a function on to a specific action".
	*
	* @author  Luciano Croce <luciano.croce@gmail.com>
	* @version 1.0.1 (Build 2018-01-11)
	* @since   1.0.0 (Build 2018-01-11)
	*/
	function remove_dashboard_widget_server_happy_nag() {
		remove_filter( 'server_panel',           'wp_server_panel' ); # draft
		remove_filter( 'serverhappy_panel', 'wp_serverhappy_panel' ); # draft
	}
}
