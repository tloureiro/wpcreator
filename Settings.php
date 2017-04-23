<?php

namespace WPCreator;

class Settings {

	public function add_to_menu() {
		add_menu_page( 'WPCreator', 'WPCreator', 'administrator', 'wpcreator', array(
			'\WPCreator\Settings',
			'create_wpcreator_page',
		), 'dashicons-wordpress-alt', 15 );
	}

	public function create_wpcreator_page() {

		$instances = WPCreator::get_created_instances(); ?>

		<h1><?php echo esc_html__( 'WPCreator', 'wpcreator' ); ?></h1>
		</br>
		<section id="create">
			<h2 class=".wrap"><?php echo esc_html__( 'Create New', 'wpcreator' );?></h2>
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

				<div>
					<label for="admin-user"><?php echo esc_html__( 'Admin User', 'wpcreator' );?>:</label>
					<input type="text" name="admin-user" >
				</div>

				<div>
					<label for="admin-password"><?php echo esc_html__( 'Admin Password', 'wpcreator' );?>:</label>
					<input type="text" name="admin-password" >
				</div>

				<?php submit_button( 'Create Wordpress Instance' ); ?>
			</form>
		</section>

		<section id="list">
			<h2 class=".wrap"><?php echo esc_html__( 'Created Instances', 'wpcreator' ); ?></h2>
			<ul>
				<?php foreach ( $instances as $instance ) : ?>
					<li>
						<a href="<?php echo site_url() . '/' . $instance ?>" target="_blank">
							<?php echo $instance ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
		<?php
	}


}