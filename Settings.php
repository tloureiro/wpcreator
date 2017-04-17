<?php

namespace WPCreator;

class Settings {

	public function add_to_menu() {
		add_menu_page( 'WPCreator', 'WPCreator', 'administrator', 'wpcreator', array(
			'\WPCreator\Settings',
			'create_wpcreator_page',
		), 'dashicons-wordpress-alt', 15 );
	}

	public function create_wpcreator_page() { ?>

		<h1><?php echo esc_html__( 'WPCreator', 'wpcreator' ); ?></h1>
		</br>
		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
			<input type="hidden" name="action" value="create_wp">
			<input type="hidden" name="_wp_http_referer" value="<?php echo urlencode( $_SERVER['REQUEST_URI'] ) ?>">

			<div>
				<label for="slug"><?php echo esc_html__( 'Slug', 'wpcreator' );?>:</label>
				<input type="text" name="slug" >
			</div>

			<div>
				<label for="title"><?php echo esc_html__( 'Title', 'wpcreator' );?>:</label>
				<input type="text" name="title" >
			</div>

			<?php submit_button( 'Create Wordpress Instance' ); ?>
		</form> <?php
	}


}