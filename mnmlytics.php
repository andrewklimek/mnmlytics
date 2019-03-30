<?php
namespace mnmlytics;
/*
Plugin Name: Minimal Analytics (mnmlytics)
Plugin URI:  https://github.com/andrewklimek/mnmlytics
Description: collect essential visitor metrics without compromising your visitors’ privacy or slowing down your site
Version:     0.3
Author:      Andrew J Klimek
Author URI:  https://github.com/andrewklimek
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Minimal Analytics is free software: you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by the Free 
Software Foundation, either version 2 of the License, or any later version.

Minimal Analytics is distributed in the hope that it will be useful, but without 
any warranty; without even the implied warranty of merchantability or fitness for a 
particular purpose. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with 
Minimal Analytics. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

register_activation_hook( __FILE__, __NAMESPACE__.'\activation' );

add_action( 'rest_api_init', function () {
	register_rest_route( 'mnmlytics/v1', '/post', array(
		'methods' => 'POST',
		'callback' => __NAMESPACE__.'\mnmlytics',
	) );
} );


function mnmlytics( $request ) {

   // $data = $request->get_params();
   // error_log(var_export($data, true));
   // error_log(var_export($request, true));	
	
	if ( 555 > $request['dw'] || 555 > $request['dh'] ) {
		$device = 'S';
	} elseif ( 888 > $request['dw'] ) {
		$device = 'M';
	} else {
		$device = 'L';
	}

	global $wpdb;

	$wpdb->insert(
	  "{$wpdb->prefix}mnmlytics",
	  array(
	     'gmt_date' => current_time( 'mysql', 1 ),
	     'local_time' => substr( $request['time'], 0, 5),
	     'ip' => $_SERVER['REMOTE_ADDR'],
	     'device' => $device,
			'device_w' => $request['dw'],
			'device_h' => $request['dh'],
			'view_w' => $request['vw'],
			'view_h' => $request['vh'],
	     'href' => $request['href'],
	     'js_referer' => $request['refer'],
	     'api_referer' => $request->get_header('referer'),
	     'server_referer' => $_SERVER['HTTP_REFERER'],
	     'pathname' => $request['path'],
	     'search' => $request['search']
	  ),
	  '%s'
	);

}

/**
 * Setup JavaScript
 */
add_action( 'wp_enqueue_scripts', function() {
	
	wp_enqueue_script( 'mnmlytics', plugin_dir_url( __FILE__ ) . 'mnmlytics.js', null, null, true );

});


add_filter('script_loader_tag', function($tag, $handle) {
	return ( 'mnmlytics' !== $handle ) ? $tag : str_replace( ' src', ' defer src', $tag );
}, 10, 2);


function backend() {
	
	// if ( ! file_exists( $path ) ) {
// 		echo '<div class="notice notice-success"><p>No log found at '. $path .'.  Hopefully this means you have no errors.</p></div>';
// 		return;
// 	}
	
	echo '<div class="wrap"><h1>Minimal Analytics</h1>';
	
	// echo '<div style="padding-top:28px;">';

	echo '</div>';
}
// add_action( 'admin_menu', function() { add_submenu_page( 'tools.php', 'Minimal Analytics', 'Minimal Analytics', 'manage_options', 'mnmlytics', __NAMESPACE__.'\backend' ); } );


function create_database() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );// to use dbDelta()
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	dbDelta( "CREATE TABLE {$wpdb->prefix}mnmlytics (
	id bigint(20) unsigned NOT NULL auto_increment,
	gmt_date datetime NOT NULL default '0000-00-00 00:00:00',
   local_time char(5),
	ip char(15),
	device char(1),
	device_w smallint(4) unsigned,
	device_h smallint(4) unsigned,
	view_w smallint(4) unsigned,
	view_h smallint(4) unsigned,
   href tinytext,
   js_referer tinytext,
	api_referer tinytext,
   server_referer tinytext,
   pathname tinytext,
	search tinytext,
	PRIMARY KEY  (id)
	) ENGINE=InnoDB $charset_collate;" );

	// update_option( 'msgmonger_messages_db_version', '1.0' );// Why not worry about version number when we update and just check for ANY version number?
}

function activation() {
	create_database();
}
