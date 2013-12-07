<?php
/**
 * Plugin Name: WordSesh Demo
 * Plugin URI:  http://wordpress.org/plugins
 * Description: The best WordPress extension ever made!
 * Version:     0.1.0
 * Author:      Eric Mann
 * Author URI:  http://eamann.com
 * License:     GPLv2+
 * Text Domain: wordsesh
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2013 Eric Mann (email : eric@eamann.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
define( 'WORDSESH_VERSION', '0.1.0' );
define( 'WORDSESH_URL',     plugin_dir_url( __FILE__ ) );
define( 'WORDSESH_PATH',    dirname( __FILE__ ) . '/' );

require_once __DIR__ . '/includes/Random_Quote_Widget.php';
require_once __DIR__ . '/includes/Topic_Suggestion.php';

add_action( 'widgets_init', function(){
	register_widget( 'Random_Quote_Widget' );
	register_widget( 'Topic_Suggestion_Widget' );
});

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function wordsesh_init() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'wordsesh' );
	load_textdomain( 'wordsesh', WP_LANG_DIR . '/wordsesh/wordsesh-' . $locale . '.mo' );
	load_plugin_textdomain( 'wordsesh', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Activate the plugin
 */
function wordsesh_activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	wordsesh_init();

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wordsesh_activate' );

/**
 * Deactivate the plugin
 * Uninstall routines should be in uninstall.php
 */
function wordsesh_deactivate() {

}
register_deactivation_hook( __FILE__, 'wordsesh_deactivate' );

function wordsesh_enqueues() {
	wp_enqueue_style( 'wordsesh', WORDSESH_URL . '/assets/css/wordsesh_demo.min.css' );

	if ( isset( $_GET['enablejs'] ) ) {
		wp_enqueue_script( 'wordsesh', WORDSESH_URL . '/assets/js/wordsesh_demo.js', array( 'jquery' ), WORDSESH_VERSION, true );
		wp_localize_script( 'wordsesh', 'wordsesh', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
}

// Wireup actions
add_action( 'init', 'wordsesh_init' );
add_action( 'wp_enqueue_scripts', 'wordsesh_enqueues' );

// Wireup filters

// Wireup shortcodes
