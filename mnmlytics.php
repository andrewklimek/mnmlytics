<?php
namespace mnmlytics;
/*
Plugin Name: Minimal Analytics (mnmlytics)
Plugin URI:  https://github.com/andrewklimek/mnmlytics
Description: collect essential visitor metrics without compromising your visitors’ privacy or slowing down your site
Version:     0.2
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
   
   // poo($_SERVER);
   // poo($request);s
	
	
	
	if ( 800 > $request['dw'] || 800 > $request['dh'] ) {
		$device = 'S';
	} elseif ( 1200 > $request['dw'] ) {
		$device = 'M';
	} else {
		$device = 'L';
	}
	
   
   $local_time = substr( $request['time'], 0, 5);
   
   $href = $request['href'];
   $js_referer = $request['referer'];
   $pathname = $request['pathname'];
   $search = $request['search'];

	$headers = $request->get_headers();
   $api_referer = $headers['referer'];
   
   $server_referer = $_SERVER['HTTP_REFERER'];
   $ip =  $_SERVER['REMOTE_ADDR'];
   
   $date_gmt_sql = current_time( 'mysql', 1 );// gmdate( 'Y-m-d H:i:s' )
   
   global $wpdb;

   $wpdb->insert(
      "{$wpdb->prefix}mnmlytics",
      array(
         'gmt_date' => $date_gmt_sql,
         'local_time' => $local_time,
         'ip' => $ip,
         'device' => $device,
			'device_w' => $request['dw'],
			'device_h' => $request['dh'],
			'view_w' => $request['vw'],
			'view_h' => $request['vh'],
         'href' => $href,
         'js_referer' => $js_referer,
         'api_referer' => $href,
         'server_referer' => $server_referer,
         'pathname' => $pathname,
         'search' => $search
      ),
      '%s'
   );

	// if ( $sent ) {
//       return "success";
//    } else {
//       return new WP_Error( 'mail_send_failed', 'mail send failed', array( 'status' => 404 ) );
//    }
	
}

/**
 * Setup JavaScript
 */
add_action( 'wp_enqueue_scripts', function() {
	
	$suffix = SCRIPT_DEBUG ? "" : ".min";
	wp_enqueue_script( 'mnmlytics', plugin_dir_url( __FILE__ ) . 'mnmlytics'.$suffix.'.js', null, null );

	//localize data for script
	// wp_localize_script( 'contactmonger-submit', 'FORM_SUBMIT', array(
// 			'url' => esc_url_raw( rest_url('formmonger/v1/submit') ),
// 			'success' => 'Thanks!',
// 			'failure' => 'Your submission could not be processed.',
// 		)
// 	);

});


add_filter('script_loader_tag', function($tag, $handle) {
	return ( 'mnmlytics' !== $handle ) ? $tag : str_replace( ' src', ' defer src', $tag );
}, 10, 2);


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