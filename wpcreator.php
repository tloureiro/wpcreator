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
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wpcreator' ) );
		}

		$url = urldecode( $_POST['_wp_http_referer']);

		$slug = filter_input( INPUT_POST, 'slug', FILTER_SANITIZE_STRING );
		$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
		$admin_user = filter_input( INPUT_POST, 'admin-user', FILTER_SANITIZE_STRING );
		$admin_password = filter_input( INPUT_POST, 'admin-password', FILTER_SANITIZE_STRING );

		if ( ! empty( $slug ) && ! empty( $title ) ) {

			$success = $this->create_wp( $slug, $title, $admin_user, $admin_password );
			wp_safe_redirect( add_query_arg( 'created', $success, $url ) );

		} else {
			wp_safe_redirect( $url );
		}
	}

	public static function create_wp( $slug, $title, $admin_user, $admin_password ) {

		$output = shell_exec( 'mkdir ' . get_home_path() . $slug );
		$output .= chdir( get_home_path() . $slug );
		$output .= shell_exec( 'wp core download' );
		$output .= shell_exec( 'wp core config --dbname=' . DB_NAME . ' --dbuser=' . DB_USER . ' --dbhost=' . DB_HOST . ' --dbpass=' . DB_PASSWORD . ' --dbprefix=' . $slug . '_ --extra-php="define( \'FS_METHOD\', \'direct\' );"' );
		$output .= shell_exec( 'wp db create' );
		$output .= shell_exec( 'wp core install --url="' . site_url() . '/' . $slug . '" --title="' . $title . '" --admin_user="' . $admin_user . '" --admin_password="' . $admin_password . '" --admin_email="o@o.com" --skip-email' );

		echo $output;
	}

	public static function get_created_instances() {

		$directories = glob( get_home_path() . '/*' , GLOB_ONLYDIR );
		$instances = [];

		foreach ( $directories as $directory ) {

			if ( file_exists( $directory . '/wp-config.php' ) ) {

				$instances[] = basename( $directory );
			}
		}

		return $instances;
	}



}

$wpcreator = new WPCreator();
