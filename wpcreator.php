<?php

namespace WPCreator;

/*
Plugin Name: WPCreator
Plugin URI:  https://example.org
Description: This plugin creates a new Wordpress instances under the root Wordpress instance using wp-cli
Version:     20170415
Author:      Thiago Loureiro
Author URI:  https://tloureiro.com/
License:     WTFPL
Text Domain: wpcreator
Domain Path: /languages
*/

require_once 'Settings.php';


class WPCreator {

	public function __construct() {

//		add_action( 'current_screen', array( __CLASS__, 'tasks' ) );
//		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );

		add_action( 'admin_menu', array( '\WPCreator\Settings', 'add_to_menu' ) );
		add_action( 'admin_post_create_wp', array( $this, 'create_wp_action_handler' ) );
	}


	public function create_wp_action_handler() {

		if ( ! current_user_can( 'administrator' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
		}

		$url = urldecode( $_POST['_wp_http_referer']);

		$slug = filter_input( INPUT_POST, 'slug', FILTER_SANITIZE_STRING );
		$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING );

		if ( ! empty( $slug ) && ! empty( $title ) ) {

			$success = WPCreator::create_wp( $slug, $title );
			wp_safe_redirect( add_query_arg( 'created', $success, $url ) );

		} else {
			wp_safe_redirect( $url );
		}
	}

	public static function create_wp( $slug, $title ) {
		$output = shell_exec( '' );
	}

}

$wpcreator = new WPCreator();
